<?php

use kartik\select2\Select2;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var array $popularAuthors */
/** @var array $availableYears */

$this->title = 'Популярные книги';
?>
<div class="site-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">ФИО</th>
            <th scope="col">Количество</th>
        </tr>
        </thead>
        <tbody>
        <? foreach ($popularAuthors as $author): ?>
            <tr>
                <th scope="row"><?= $author->id ?></th>
                <td><?= $author->fio ?></td>
                <td><?= count($author->books) ?></td>
            </tr>
        <? endforeach; ?>
        </tbody>
    </table>

    <form>
        <div class="row">
            <div class="col-3">
                <?= Select2::widget([
                    'name' => 'year',
                    'data' => array_combine($availableYears, $availableYears),
                    'options' => ['placeholder' => 'Выберите год ...'],
                    'pluginOptions' => [
                        'allowClear' => true,
                        'tags' => true,
                    ],
                ]); ?>
            </div>
            <div class="col-3">
                <?= Html::submitButton('Выбрать', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </form>
</div>
