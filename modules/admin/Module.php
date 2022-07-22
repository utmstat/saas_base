<?php

namespace app\modules\admin;

use app\components\helpers\AppHelper;
use yii\web\NotFoundHttpException;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!AppHelper::isAdmin()) {
            throw new NotFoundHttpException();
        }

        parent::init();
    }
}
