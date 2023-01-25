<?php
/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 27.05.17
 * Time: 13:39
 */

namespace app\components\common;

use app\models\Project;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Class AppController
 * @package app\components\common
 */
class AppController extends Controller
{
    /** @var int|null */
    protected $userId;

    /** @var int|null */
    protected $projectId;

    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'controllers' => [
                            'site'
                        ],
                        'actions' => [
                            'index',
                        ]
                    ],
                    [
                        'allow' => true,
                        'roles' => ['?'],
                        'controllers' => ['site'],
                        'actions' => ['login', 'register', 'index', 'recovery', 'reset-password']
                    ],
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                    ]
                ]
            ]
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function init()
    {
        $user = User::getCurrentUser();
        $project = Project::getCurrentProject();
        $this->projectId = $project->id ?? null;
        $this->userId = $user->id ?? null;
        parent::init();
    }

    private function loginByToken()
    {
        if (Yii::$app->user->isGuest) {
            $token = Yii::$app->request->get('access-token');
            if ($token) {
                $identity = User::findIdentityByAccessToken($token);
                if ($identity) {
                    Yii::$app->getUser()->login($identity);
                } else {
                    Yii::error('Identity not found for access-token ' . $token, __METHOD__);
                }
            }
        }
    }

}