<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model amilna\blog\models\StaticPage */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => Yii::t('app','Static Page'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Static Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-page-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
