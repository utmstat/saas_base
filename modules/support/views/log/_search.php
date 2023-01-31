<?php

use app\components\widgets\SearchButtonsWidget;
use kartik\date\DatePicker;
use yii\bootstrap4\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\LogSearch */
/* @var $form yii\bootstrap4\ActiveForm */
?>

<div class="log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-md-2">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'level') ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'category') ?>
        </div>

        <div class="col-md-2">
            <?= $form->field($model, 'log_time')->widget(DatePicker::class, [
                'language' => 'ru',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd',
                ]]); ?>

        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'prefix') ?>
        </div>

    </div>





    <?= SearchButtonsWidget::widget() ?>

    <?php ActiveForm::end(); ?>

</div>
