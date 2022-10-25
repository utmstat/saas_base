<?php

/* @var $this View */

/* @var $content string */

use app\assets\AppAsset;
use app\components\widgets\FlashWidget;
use app\components\widgets\FooterWidget;
use app\components\widgets\SeoWidget;
use app\components\widgets\TopMenuWidget;
use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\NavBar;
use app\components\widgets\JsVarsWidget;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= SeoWidget::widget(['externalView' => $this]) ?>
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-light fixed-top',
            'style' => 'background-color: #e3f2fd;'
        ],
    ]);
    echo TopMenuWidget::widget();
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>

        <?= JsVarsWidget::widget() ?>
        <?= FlashWidget::widget() ?>
        <?= $content ?>
    </div>
</div>

<?= FooterWidget::widget() ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
