<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\firm\FirmCatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="firm-cat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'id_parent') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'order') ?>

    <?= $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'slug') ?>

    <?php // echo $form->field($model, 'mk') ?>

    <?php // echo $form->field($model, 'md') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
