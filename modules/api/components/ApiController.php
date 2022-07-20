<?php

/**
 * Created by PhpStorm.
 * User: alekseylaptev
 * Date: 30.05.17
 * Time: 23:31
 */

namespace app\modules\api\components;

use app\components\common\RestController;

/**
 * Class ApiController
 * @package app\modules\api\components
 */
class ApiController extends RestController
{
    
    public function actionTest()
    {
        $this->response->data = 'test';
    }
}