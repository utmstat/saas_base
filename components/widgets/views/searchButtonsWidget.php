<?php

use yii\helpers\Html;
use yii\web\View;

/**
 * @var View $this
 * @var string $clearUrl
 * @var string $resetUrl
 * @var string $showHr
 */

?>
    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Сбросить', $resetUrl, ['class' => 'btn btn-default']) ?>
        <?php if ($clearUrl): ?>
            <?= Html::a('Очистить', $clearUrl, ['class' => 'btn btn-danger']) ?>
        <?php endif; ?>
    </div>

<?php if ($showHr): ?>
    <hr>
<?php endif; ?>