<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Subscription $model */

$this->title = 'Подписаться';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscription-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
