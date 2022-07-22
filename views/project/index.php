<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\components\widgets\TableActionsWidget;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проекты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <p>
        <?= Html::a('Создать проект', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => '',
        'columns' => [
            'id',
            'name',
//            'updated_at',
//            'created_at',
            'actions' => [
                'value' => function ($model) {
                    return TableActionsWidget::widget([
                        'model' => $model,
                        'canDelete' => $model->canDelete()
                    ]);
                },
                'format' => 'raw'
            ],
        ],
    ]); ?>


</div>
