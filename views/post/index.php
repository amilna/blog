<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/default']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    
    <div class="pull-right col-md-3 col-xs-6">
		<form action="<?=Yii::$app->urlManager->createUrl("//blog/post")?>" method="get">
			<div class="input-group">
				<input class="form-control input-md" name="PostSearch[term]" id="appendedInputButtons" type="text">
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
		'itemOptions' => ['class' => 'col-md-4 col-sm-6','tag'=>'div'],		
		//'summary'=>Yii::t('app','List of account codes where increase on receipt or revenues'),		
		'itemView'=>'_itemIndex',
		'options' => ['class' => 'row text-center'],		
		'layout'=>"{items}\n{pager}",
	]) ?>	

</div>
