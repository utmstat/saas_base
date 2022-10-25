<?php

use yii\web\View;

/* @var $this View */
/* @var $messages array */

?>
<?php foreach ($messages as $message): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $message ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endforeach; ?>
