<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use amilna\blog\models\Category;

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-view">
<!--
    <h1><?= Html::encode($this->title) ?></h1>    

	<div class="row">		
		<div class="col-sm-12 panel">			
			<div class="panel-body">
				<div>
					<h3><small><i class="glyphicon glyphicon-time"></i>  <?= date('D d M, Y',strtotime($model->time)) ?> </small></h3>
				</div>								
				<div>
-->				
					<?= $model->content ?>
<!--					
				</div>				
			</div>
		</div>			
	</div>
-->
</div>

<script>
<?php $this->beginBlock('STATIC_SCRIPTS') ?>
<?= $model->scripts ?>   
<?php $this->endBlock(); ?>
</script>
<?php
yii\web\YiiAsset::register($this);
$this->registerJs($this->blocks['STATIC_SCRIPTS'], yii\web\View::POS_END);
