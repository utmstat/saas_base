<?php

namespace app\components\widgets;

use app\components\common\AppWidget;

class LandingMobileWidget extends AppWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        return $this->render('landingMobileWidget',
            [
            ]
        );
    }

}