<?php

use yii\web\View;

/* @var $this View */
/* @var $title string */
/* @var $description string */
/* @var $ogTitle string */
/* @var $ogType string */
/* @var $ogUrl string */
/* @var $ogDescription string */
/* @var $ogSiteName string */
/* @var $ogImage string */
/* @var $ogImageWidth int */
/* @var $ogImageHeight int */
?>
<meta charset="<?= Yii::$app->charset ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= $title ?></title>
<meta charset="utf-8">
<meta name="author" content="LMSly">
<meta http-equiv="X-UA-Compatible" content="IE=EDGE">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="robots" content="all">
<meta name="description" content="<?= $description ?>">
<meta property="og:title" content="<?= $ogTitle ?>">
<meta property="og:type" content="<?= $ogType ?>">
<meta property="og:url" content="<?= $ogUrl ?>">
<meta property="og:description" content="<?= $ogDescription ?>">
<meta property="og:site_name" content="<?= $ogSiteName ?>">
<meta property="og:image" content="<?= $ogImage ?>">
<meta property="og:image:width" content="<?= $ogImageWidth ?>">
<meta property="og:image:height" content="<?= $ogImageHeight ?>">