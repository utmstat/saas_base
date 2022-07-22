<?php

namespace app\modules\support;

use app\components\helpers\AppHelper;
use yii\web\NotFoundHttpException;

/**
 * support module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\support\controllers';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        if (!AppHelper::isSupport()) {
            throw new NotFoundHttpException();
        }

        parent::init();
    }
}
