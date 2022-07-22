<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\RecoveryForm */

/* @var $tokenFailure bool */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Alert;
use yii\helpers\Html;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin([
    'id' => 'recovery-form',
    'options' => [
        'class' => 'form-signin'
    ],
]); ?>

<h1 class="h3 mb-3 font-weight-normal"><?= Html::encode($this->title) ?></h1>

<?php if ($tokenFailure): ?>
    <?= Alert::widget([
        'body' => 'Токен не найден или закончился срок его действия',
        'closeButton' => false,
        'options' => ['class' => 'alert-danger']
    ]) ?>

    <p>
        <a class="recovery-link text-muted" style="font-size: 11px" href="/login">Войти</a>
    </p>
<?php else: ?>

    <?= $form->field($model, 'password')->passwordInput(['autofocus' => true, 'placeholder' => 'Новый пароль'])->label(false) ?>

    <?= $form->field($model, 'passwordRepeat')->passwordInput(['placeholder' => 'Повторить пароль'])->label(false) ?>


    <div class="form-group">
        <?= Html::submitButton('Отправить',
            ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>

<?php endif; ?>

<?php ActiveForm::end(); ?>
