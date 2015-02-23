<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use himiklab\colorbox\Colorbox;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\GallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Galleries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/default']];
$this->params['breadcrumbs'][] = $this->title;

$module = Yii::$app->getModule('blog');
?>
<div class="gallery-index">    
    
    <div class="pull-right col-md-3 col-xs-6">
		<form action="index" method="get">
			<div class="input-group">
				<input class="form-control input-md" name="GallerySearch[term]" id="appendedInputButtons" type="text">
				<span class="input-group-btn">
					<button class="btn btn-md" type="submit">Search</button>
				</span>
			</div>
		</form>
	</div>
	<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>    
		
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'itemOptions' => ['class' => 'pull-left','tag'=>'ul'],
		//'summary'=>Yii::t('app','List of account codes where increase on receipt or revenues'),		
		//'itemView'=>(isset($_GET['GallerySearch[album]'])?'_itemTag':'_itemAll'),	
		'options' => ['class' => 'row text-center'],		
		'layout'=>"{items}{pager}",
		'itemView' => function ($model, $key, $index, $widget) use ($module) {					
						$html = '<div class="thumbnail">
									<a href="'.$model->url.'" class="colorbox" title="'.$model->title.'"><img src="'.str_replace("/".$module->uploadDir."/","/".$module->uploadDir."/.thumbs/",$model->url).'" alt="'.$model->title.'"></a>
									<!--<div class="caption">
										<h4>'.Html::a($model->title,["//blog/gallery/view?id=".$model->id]).'</h4>
										<p>'.Html::encode($model->description).'</p>
									</div>-->
								</div>';
										
						return $html;
					},
				
		//'itemsTagName'=>'ul',
		//'template'=>"{items}{pager}",
		//'itemsCssClass'=>'ace-thumbnails clearfix',	
	]) ?>	

</div>

<?= Colorbox::widget([
    'targets' => [
        '.colorbox' => [
            'maxWidth' => 800,
            'maxHeight' => 600,
            'rel'=>'colorbox',
            'slideshow'=>true
        ],
    ],
    'coreStyle' => 1
]) ?>
