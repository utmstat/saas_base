<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model app\models\RegistrationForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;

$this->title = 'Регистрация в ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'register-form',
    'options' => [
        'class' => 'form-signin'
    ],

]); ?>

    <h4 class="h4 mb-3 font-weight-normal"><?= Html::encode($this->title) ?></h4>


<?= $form->field($model, 'phone')->textInput(['autofocus' => true, 'placeholder' => 'Телефон'])->label(false) ?>

<?= $form->field($model, 'email')->textInput(['placeholder' => 'Email'])->label(false) ?>

<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться',
            ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>

    <p>
        <a class="recovery-link text-muted" style="font-size: 11px" href="/login">Войти</a>
    </p>

<?php ActiveForm::end(); ?>