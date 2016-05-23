<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Gallery */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('app','Gallery'),
]) . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="gallery-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
