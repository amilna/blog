<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\GallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Galleries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gallery-index">    
    
    <div class="pull-right col-md-3 col-xs-6">
		<form action="index" method="get">
			<div class="input-group">
				<input class="form-control input-md" name="GallerySearch[search]" id="appendedInputButtons" type="text">
				<span class="input-group-btn">
					<button class="btn btn-md" type="button">Search</button>
				</span>
			</div>
		</form>
	</div>
	<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>    
		
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'itemOptions' => ['class' => 'col-md-3 col-sm-6 clearfix','tag'=>'ul'],
		//'summary'=>Yii::t('app','List of account codes where increase on receipt or revenues'),		
		//'itemView'=>(isset($_GET['GallerySearch[album]'])?'_itemTag':'_itemAll'),	
		'options' => ['class' => 'row text-center'],		
		'layout'=>"{items}{pager}",
		'itemView' => function ($model, $key, $index, $widget) {					
						$html = '<div class="thumbnail">
									<img src="'.$model->url.'" alt="'.$model->title.'">
									<div class="caption">
										<h4>'.Html::a($model->title,["//blog/gallery/view?id=".$model->id]).'</h4>
										<p>'.$model->description.'</p>
									</div>
								</div>';
										
						return $html;
					},
				
		//'itemsTagName'=>'ul',
		//'template'=>"{items}{pager}",
		//'itemsCssClass'=>'ace-thumbnails clearfix',	
	]) ?>	

</div>
