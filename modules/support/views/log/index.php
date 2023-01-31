<?php

use app\modules\support\components\widgets\LogErrorsWidget;
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ошибки';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="log-index">
    <h1><?=$this->title;?></h1>

    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="col-md-12">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
//            'filterModel' => $searchModel,
            'columns' => [
                'id',
                'level',
                'category',
                'log_time:datetime',
                'prefix:ntext',
                // 'message:ntext',
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    <div class="col-md-2 text-left">
        <h1><?= Html::encode($this->title) ?></h1>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <p>
            <?= Html::a('Очистить', '/support/log/clear', ['class' => 'btn btn-danger']) ?>
        </p>
    </div>
    <div class="col-md-8 text-left">
        <?= LogErrorsWidget::widget(['group' => ['category']]) ?>
        <hr>
        <?= LogErrorsWidget::widget() ?>
    </div>
</div>
