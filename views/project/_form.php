<?php

use app\components\widgets\FormButtonsWidget;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="project-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= FormButtonsWidget::widget() ?>

    <?php ActiveForm::end(); ?>

</div>
