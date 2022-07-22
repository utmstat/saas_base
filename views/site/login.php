<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\LoginForm */

/* @var $passwordReset bool */

use app\components\helpers\ImageHelper;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Alert;
use yii\helpers\Html;

$this->title = 'Войти в ' . Yii::$app->name;
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => [
        'class' => 'form-signin'
    ],
]); ?>


<h1 class="h3 mb-3 font-weight-normal"><?= Html::encode($this->title) ?></h1>

<?php if ($passwordReset): ?>
    <?= Alert::widget([
        'body' => 'Пароль успешно изменен',
        'closeButton' => false,
        'options' => ['class' => 'alert-success']
    ]) ?>
<?php endif; ?>

<?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>

<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль'])->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Войти', ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
</div>

<?= $form->field($model, 'rememberMe')->checkbox() ?>


<p>
    <a class="recovery-link text-muted" style="font-size: 11px" href="/recovery">Забыли пароль?</a>
</p>

<p>
    <a class="recovery-link text-muted" style="font-size: 11px" href="/register">Регистрация</a>
</p>

<?php ActiveForm::end(); ?>
