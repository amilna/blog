<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Files');
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
		'itemOptions' => ['class' => 'col-md-3 col-sm-4 item','tag'=>'div'],		
		//'summary'=>Yii::t('app','List of account codes where increase on receipt or revenues'),		
		'itemView'=>'_itemIndex',
		'options' => ['class' => 'row text-center list-view'],		
		'layout'=>"{items}\n{pager}",
		//'pager' => ['class' => \kop\y2sp\ScrollPager::className()],
	]) ?>	

</div>

