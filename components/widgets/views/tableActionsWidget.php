<?php

use yii\db\ActiveRecord;
use yii\helpers\Html;

/** @var $model ActiveRecord */

?>

<?php foreach ($this->context->customs as $custom): ?>
    <?= Html::a($custom['text'], $custom['url'], $custom['options']) ?>
<?php endforeach; ?>

<?php if ($this->context->canView): ?>
    <?= Html::a('Просмотр', ['view', 'id' => $model->id], ['class' => 'btn btn-info btn-sm']) ?>
<?php endif; ?>

<?php if ($this->context->canEdit): ?>
    <?= Html::a('Изменить', ['update', 'id' => $model->id],
        ['class' => 'btn btn-warning btn-sm', 'style' => 'margin-bottom: 2px']) ?>
<?php else: ?>
    <?= Html::button('Изменить', ['class' => 'btn btn-warning btn-sm', 'disabled' => true]) ?>
<?php endif ?>

<?php if ($this->context->canDelete): ?>
    <?= Html::a('Удалить', ['delete', 'id' => $model->id],
        ['class' => 'btn btn-danger btn-sm', 'style' => 'margin-bottom: 2px']) ?>
<?php else: ?>
    <?= Html::button('Удалить',
        ['class' => 'btn btn-danger btn-sm', 'disabled' => true, 'style' => 'margin-bottom: 2px']) ?>
<?php endif ?>

<?php if ($this->context->canRestore): ?>
    <?= Html::a('Восстановить', ['restore', 'id' => $model->id],
        ['class' => 'btn btn-default btn-sm', 'style' => 'margin-bottom: 2px']) ?>
<?php endif ?>

<?php if ($this->context->canCopy): ?>
    <?= Html::a('Копировать', ['copy', 'id' => $model->id],
        ['class' => 'btn btn-default btn-sm', 'style' => 'margin-bottom: 2px']) ?>
<?php endif ?>

<?php if ($this->context->canRecommendation): ?>
    <?= Html::a('Помощь', ['help', 'id' => $model->id],
        ['class' => 'btn btn-info btn-sm', 'style' => 'margin-bottom: 2px']) ?>
<?php endif ?>


