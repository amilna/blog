<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Category */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$module = Yii::$app->getModule('blog');
?>
<div class="category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'parent_id',
            'description:ntext',
            [
				'attribute'=>'image',
				'format'=>'html',
				'value'=>(!empty($model->image)?(Html::img(str_replace("/".$module->uploadDir."/","/".$module->uploadDir."/.thumbs/",$model->image))):''),
            ],       
            'status:boolean',     
            //'isdel',
        ],
    ]) ?>

</div>
