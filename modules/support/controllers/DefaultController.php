<?php

namespace app\modules\support\controllers;

use app\modules\support\components\SupportController;

/**
 * Default controller for the `sales` module
 */
class DefaultController extends SupportController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}
