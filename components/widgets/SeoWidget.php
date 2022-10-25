<?php

namespace app\components\widgets;

use app\components\common\AppWidget;
use app\components\helpers\SeoHelper;
use yii\web\View;

class SeoWidget extends AppWidget
{
    /* @var View */
    public $externalView;

    public function run()
    {
        $title = $this->externalView->title;

        if (!$title) {
            $title = SeoHelper::getTitle();
        }

        $description = SeoHelper::getDescription();
        $ogTitle = $title;
        $ogType = 'website';
        $ogUrl = \Yii::$app->request->absoluteUrl;
        $ogDescription = $description;
        $ogSiteName = '';

        return $this->render('seoWidget', [
            'title' => $title,
            'description' => $description,
            'ogTitle' => $ogTitle,
            'ogType' => $ogType,
            'ogUrl' => $ogUrl,
            'ogDescription' => $ogDescription,
            'ogSiteName' => $ogSiteName,
            'ogImage' => SeoHelper::getOgImage(),
            'ogImageWidth' => 1200,
            'ogImageHeight' => 600,
        ]);
    }
}