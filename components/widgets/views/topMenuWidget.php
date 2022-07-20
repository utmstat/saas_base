<?php

use yii\bootstrap4\Nav;

/**
 * @var array $items
 */

echo Nav::widget([
    'options' => ['class' => 'navbar-nav navbar-right'],
    'items' => $items,
]);

?>