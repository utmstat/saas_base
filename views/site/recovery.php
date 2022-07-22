<?php

/* @var $this yii\web\View */

/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model app\models\RecoveryForm */

/* @var $success bool */

use app\components\helpers\ImageHelper;
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

<?php if ($success): ?>
    <?= Alert::widget([
        'body' => 'Сообщение успешно отправлено. Проверьте ваш почтовый ящик',
        'closeButton' => false,
        'options' => ['class' => 'alert-success']
    ]) ?>
<?php else: ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => 'Email'])->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить',
            ['class' => 'btn btn-lg btn-primary btn-block', 'name' => 'login-button']) ?>
    </div>

    <p>
        <a class="recovery-link text-muted" style="font-size: 11px" href="/login">Войти</a>
    </p>

<?php endif ?>

<?php ActiveForm::end(); ?>
