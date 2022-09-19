<?php

namespace app\components\widgets;

use app\components\common\AppWidget;
use app\components\helpers\SeoHelper;
use Yii;

class LandingDesktopWidget extends AppWidget
{
    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $logo = Yii::getAlias('@app') . '/web/images/land_logo.png';
        $title = 'SAAS Service title';
        $description = 'SAAS Service description';

        SeoHelper::setTitle($title);
        SeoHelper::setDescription($description);

        return $this->render('landingDesktopWidget',
            [
                'logo' => $logo,
                'title' => $title,
                'description' => $description,
            ]
        );
    }
}