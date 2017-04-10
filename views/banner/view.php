<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Banner */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Banners'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$module = Yii::$app->getModule('blog');
?>
<style>
	.banner-view .thumbnail {
		max-width:100%!important;	
	}
</style>
<div class="banner-view">
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
			<?= Html::img($model->image,["style"=>"max-width:100%"])?>
		</div>		
		<div class="col-xs-4">
			<?= DetailView::widget([
				'model' => $model,
				'attributes' => [
					'id',
					'title',
					'description',            
					[
						'attribute'=>'front_image',
						'format'=>'html',
						'value'=>(!empty($model->front_image)?(Html::img(str_replace($module->uploadURL."/",$module->uploadURL."/.thumbs/",$model->front_image),["class"=>"thumbnail","style"=>"max-width:100%"])):''),
					],  				  
					'tags',
					'url:url',
					'status:boolean',
					'position',
					'time',
					//'isdel',
				],
			]) ?>
		</div>
	</div>
	
    
</div>
