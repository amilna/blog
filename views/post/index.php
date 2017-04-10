<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = (!empty($_GET["category"])?$_GET["category"]:Yii::t('app', 'Posts'));
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/default']];
$this->params['breadcrumbs'][] = $this->title;

$dataProvider->pagination = [
	'pageSize'=> 12,
];
?>
<div class="post-index">
        	
	<h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>    
		
	<?= ListView::widget([
		'dataProvider' => $dataProvider,
		'itemOptions' => ['class' => 'col-md-4 col-sm-6 item','tag'=>'div'],		
		//'summary'=>Yii::t('app','List of account codes where increase on receipt or revenues'),		
		'itemView'=>'_itemIndex',
		'options' => ['class' => 'row text-center list-view'],		
		'layout'=>"{items}<div class='row'></div>{pager}",
		//'pager' => ['class' => \kop\y2sp\ScrollPager::className()],
	]) ?>	

</div>

