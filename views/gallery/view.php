<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Gallery */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

if ($model->type == 1)
{
	\amilna\blog\assets\FlowAsset::register($this);	
}
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
			<?php 
				if ($model->type == 1) 
				{
					$gdd = Yii::$app->assetManager->getPublishedUrl((new \amilna\blog\assets\FlowAsset)->sourcePath);
					$url = (substr($model->url,0,4) == "http"?$model->url:$gdd."?url=".$model->url."&image=".$model->image."&auto=false");
					echo "<iframe align=middle frameborder=0 seamless=true width=100% height=390 style='max-height:390px:' src='".$url."'></iframe>";
				}
				else
				{
					echo Html::img($model->image,["style"=>"max-width:100%"]);
				}			
			?>			
		</div>
		<div class="col-xs-4">
			<?= DetailView::widget([
				'model' => $model,
				'attributes' => [
					//'id',
					'title',
					'description',					
					'tags',
					'status:boolean',
					'time',
					[
						'attribute'=>'type',
						'value'=>$model->itemAlias('type',$model->type),
					],					
					//'isdel',
				],
			]) ?>
		</div>
	</div>    

</div>
