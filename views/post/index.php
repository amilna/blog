<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">
    
    <div class="pull-right col-md-4 col-xs-6">
		<form action="index" method="get">
			<div class="input-group">
				<input class="form-control input-md" name="PostSearch[search]" id="appendedInputButtons" type="text">
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
		'itemOptions' => ['class' => 'row','tag'=>'div'],		
		//'summary'=>Yii::t('app','List of account codes where increase on receipt or revenues'),		
		'itemView'=>'_itemIndex',
		'layout'=>"{items}\n{pager}",
	]) ?>	

</div>
