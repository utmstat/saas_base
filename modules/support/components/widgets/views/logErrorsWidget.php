<?php

use app\components\helpers\TextHelper;
use yii\web\View;

/** @var $this View */
/** @var $data array */

?>
<table>
    <?php foreach ($data as $value): ?>
        <tr>
            <td>
                <span class="label label-warning"><?= $value['counter'] ?> </span>
            </td>
            <td>
                <?= $value['category'] ?>
            </td>
            <td>
                <small>
                    <?= TextHelper::subStr($value['message'], 0, 255) ?>
                </small>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
