<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model amilna\blog\models\File */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => Yii::t('app','File'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Files'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
