<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var app\models\BookForm $model */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\Author[] $authors */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'year')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'photo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author_ids')->widget(Select2::classname(), [
        'data' => ArrayHelper::map($authors,'id', 'fio'),
        'options' => ['placeholder' => 'Выберите авторов ...', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => true,
            'tags' => true,
        ],
    ]); ?>

<!--    --><?//= Select2::widget([
//        'name' => 'author_ids',
//        'data' => ArrayHelper::map($authors,'id', 'fio'),
//        'options' => ['placeholder' => 'Выберите авторов ...', 'multiple' => true],
//        'pluginOptions' => [
//            'allowClear' => true,
//            'tags' => true,
//        ],
//    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
