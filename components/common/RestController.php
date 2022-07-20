<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 04.06.17
 * Time: 19:21
 */

namespace app\components\common;

use Yii;
use yii\base\Exception;
use yii\filters\Cors;
use yii\rest\Controller;
use yii\web\Response;

class RestController extends Controller
{
    /**
     * @var ApiResponse
     */
    protected $apiResponse;

    protected $token;

    protected $projectId;

    const ACCESS_TOKEN_PARAM = 'access-token';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = [
            'application/json' => Response::FORMAT_JSON,
            'text/html' => Response::FORMAT_JSON,
            'text/plain' => Response::FORMAT_JSON,
            'application/octet-stream' => Response::FORMAT_JSON,
        ];
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => true,
            ]
        ];

        unset($behaviors['rateLimiter']);

        return $behaviors;
    }

    public function init()
    {
        parent::init();
        $this->token = Yii::$app->request->get(self::ACCESS_TOKEN_PARAM);
        $this->projectId = Yii::$app->request->post('project_id');
        $this->apiResponse = new ApiResponse();
    }

    public function runAction($id, $params = [])
    {
        parent::runAction($id, $params);

        return $this->prepareResponseData();
    }

    /**
     * @return array
     * @throws Exception
     */
    protected function prepareResponseData()
    {
        if (!$this->apiResponse->status) {
            if ($this->apiResponse->has_error) {
                $this->apiResponse->status = 400;
            } else {
                $this->apiResponse->status = 200;
            }
        }

        $this->response->setStatusCode($this->apiResponse->status);

        if (!in_array($this->apiResponse->status, [200, 400, 403, 404, 500])) {
            throw new Exception('Invalid response status, use [200, 400, 403, 404, 500]');
        }

        $this->response->headers->set('Access-Control-Allow-Origin', '*');
        $this->response->headers->set('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');

        if ($this->apiResponse->onlyDataAsResponse) {
            $result = $this->apiResponse->data;
        } else {
            $result = [
                'status' => $this->apiResponse->status,
                'has_error' => $this->apiResponse->has_error,
                'message' => $this->apiResponse->message,
                'data' => $this->apiResponse->data
            ];
        }
        return $result;
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action); 
    }
}