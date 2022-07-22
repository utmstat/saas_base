<?php

use yii\bootstrap4\Nav;

/**
 * @var array $items
 * @var string $class
 * @var array $leftItems
 * @var array $rightItems
 */

if ($leftItems) {
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left mr-auto'],
        'items' => $leftItems,
    ]);
}

echo Nav::widget([
    'options' => ['class' => $class],
    'items' => $items,
]);

?>

<?php if (!Yii::$app->user->isGuest) : ?>
    <div class="navbar-nav ml-auto">
        <?php
        echo Nav::widget([
            'options' => ['class' => 'navbar-nav navbar-right mr-auto'],
            'items' => $rightItems,
        ]);
        ?>
    </div>
<?php endif; ?>
