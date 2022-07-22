<?php

namespace app\modules\admin\components;

use app\components\common\AppController;

/**
 * Class AdminController
 * @package app\modules\admin\components
 */
class AdminController extends AppController
{
    public function init()
    {
        parent::init();
        $this->layout = '@app/modules/admin/views/layouts/main';
    }
}