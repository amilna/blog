<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use himiklab\colorbox\Colorbox;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\GallerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

\amilna\blog\assets\FlowAsset::register($this);

$req = Yii::$app->request->queryParams;

$this->title = Yii::t('app', 'Galleries');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/default']];
if (isset($req["GallerySearch"]["tag"]))
{
	$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Galleries'), 'url' => ['/blog/gallery']];
	$this->title = ucwords($req["GallerySearch"]["tag"]);
}
$this->params['breadcrumbs'][] = $this->title;

$this->params['cboxTarget'] = [];
$module = Yii::$app->getModule('blog');

?>
<style>
.nopadding {
   padding: 0 !important;
   margin: 0 !important;
}
</style>

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
		'dataProvider' => new ArrayDataProvider([
			'allModels' => $albums,			
			'pagination' => [
				'pageSize' => 12,
			],
		]),
		'itemOptions' => ['class' => 'pull-left','tag'=>'ul'],
		//'summary'=>Yii::t('app','List of account codes where increase on receipt or revenues'),				
		'options' => ['class' => 'row text-center'],		
		'layout'=>"{items}{pager}",
		'itemView'=>(isset($req["GallerySearch"]["tag"])?'_itemTag':'_itemAll'),	
		/*'itemView' => function ($model, $key, $index, $widget) use ($module) {					
						$html = '<div class="thumbnail">
									<a href="'.$model->image.'" class="colorbox" title="'.$model->title.'"><img src="'.str_replace("/".$module->uploadDir."/","/".$module->uploadDir."/.thumbs/",$model->image).'" alt="'.$model->title.'"></a>
									<!--<div class="caption">
										<h4>'.Html::a($model->title,["//blog/gallery/view?id=".$model->id]).'</h4>
										<p>'.Html::encode($model->description).'</p>
									</div>-->
								</div>';
										
						return $html;
					},
		*/		
		//'itemsTagName'=>'ul',
		//'template'=>"{items}{pager}",
		//'itemsCssClass'=>'ace-thumbnails clearfix',	
	]) ?>	

</div>

<?= Colorbox::widget([
    'targets' => $this->params['cboxTarget'],        
    'coreStyle' => 1
]) ?>
