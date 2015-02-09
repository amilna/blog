<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Gallery */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-view">

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
	
	<div class="row">
		<div class="col-xs-8">
			<?= Html::img($model->url,["style"=>"width:100%"])?>
		</div>
		<div class="col-xs-4">
			<?= DetailView::widget([
				'model' => $model,
				'attributes' => [
					//'id',
					'title',
					'description',
					//'url:ntext',
					'tags',
					'status:boolean',
					'time',
					//'type',					
					//'isdel',
				],
			]) ?>
		</div>
	</div>    

</div>
