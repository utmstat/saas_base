<?php

namespace app\modules\support\components;

use app\components\common\AppController;

class SupportController extends AppController
{

    public function init()
    {
        parent::init();
        $this->layout = '@app/modules/support/views/layouts/main';
    }
}