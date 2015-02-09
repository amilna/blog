<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\BannerSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'image') ?>

    <?= $form->field($model, 'front_image') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'status')->checkbox() ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'time') ?>

    <?php // echo $form->field($model, 'isdel') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
