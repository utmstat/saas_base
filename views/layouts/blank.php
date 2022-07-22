<?php

/* @var $this View */

/* @var $content string */

use app\assets\AppAsset;
use app\components\widgets\JsVarsWidget;
use yii\bootstrap4\BootstrapAsset;
use yii\web\View;

AppAsset::register($this);
BootstrapAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?php $this->registerCsrfMetaTags() ?>
    <?php $this->head() ?>
</head>
<body class="text-center flex">
<?php $this->beginBody() ?>
<?= JsVarsWidget::widget() ?>
<?= $content ?>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
