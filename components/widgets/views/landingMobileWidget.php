<?php

use app\components\helpers\ImageHelper;

?>
<div class="py-5 text-center">
    <img class="d-block mx-auto mb-4" src="<?= ImageHelper::getResizeToWidth(ImageHelper::getLogoFilename(), 72) ?>"
         alt="" width="72" height="72">
    <h2><?= Yii::$app->name ?></h2>
</div>