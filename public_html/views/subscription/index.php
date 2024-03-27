<?php

use app\models\Subscription;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Подписки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'author.fio',
            'phone',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Subscription $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                'visibleButtons' => [
                    'update' => function ($model) {
                        return false;
                    },
                    'view' => function ($model) {
                        return false;
                    },
                ]
            ],
        ],
    ]); ?>


</div>
