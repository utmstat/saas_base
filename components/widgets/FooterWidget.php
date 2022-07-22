<?php

namespace app\components\widgets;

use app\components\common\AppWidget;

class FooterWidget extends AppWidget
{
    /**
     * @inheritDoc
     */
    public function run(){
        return $this->render('footerWidget');
    }
}