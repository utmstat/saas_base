<?php

namespace app\modules\api\controllers;

use app\modules\api\components\ApiController;

/**
 * Default controller for the `api` module
 */
class DefaultController extends ApiController
{
    public function actionIndex()
    {
        $this->apiResponse->setMessage('test api');
    }
}
