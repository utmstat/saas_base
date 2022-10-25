<?php
/**
 * Created by PhpStorm.
 * User: aleksey
 * Date: 09.06.17
 * Time: 1:19
 */

namespace app\modules\support\components\widgets;


use app\components\common\AppWidget;
use app\models\Log;

class LogErrorsWidget extends AppWidget
{

    public $group = ['category', 'message'];

    public function run()
    {
        $data = Log::find()
            ->select('category, count(id) AS counter, message')
            ->groupBy($this->group)
//            ->where(['NOT IN', 'category', ['application', 'yii\web\HttpException:401', '	yii\web\HttpException:403', 'yii\web\HttpException:404', 'yii\web\HttpException:403']])
            ->orderBy('counter DESC')
            ->asArray()
            ->all();

        return $this->render('logErrorsWidget', ['data' => $data]);
    }

}