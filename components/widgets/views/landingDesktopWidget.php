<?php

use yii\web\View;

/** @var $this View */
/** @var $title string */
/** @var $description string */

?>

<div class="jumbotron">
    <div class="row">
        <div class="col text-left" style="width: 50%">
            <h1 class="display-5"><?= $title ?></h1>
            <p class="lead"><?= $description ?></p>
        </div>
<!--        <div class="col text-right" style="width: 50%">-->
<!--            <img class="rounded" src="--><?//= ImageHelper::getResizeToWidth($logo, 450) ?><!--">-->
<!--        </div>-->
    </div>
</div>