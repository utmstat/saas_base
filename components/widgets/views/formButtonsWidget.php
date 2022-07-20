<?php

use yii\bootstrap4\Html;

$action = Yii::$app->controller->action->id;

$isNewRecord = $action == 'create';

?>

<hr>

<div class="form-group">
    <?= Html::submitButton($isNewRecord ? $this->context->createText : $this->context->updateText, [
        'class' => $isNewRecord ? 'btn btn-success' : 'btn btn-primary',
        'id' => $this->context->id
    ]) ?>
</div>