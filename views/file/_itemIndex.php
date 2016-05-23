<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */

$module = Yii::$app->getModule('blog');
?>

	<div class="thumbnail">	
	
		<div >										
			<div class="caption text-left"  style="margin:0px 0px 0px 0px;background:#ffffff;padding:20px;">
				<h3><?= Html::a($model->title,$model->file,["target"=>"blank"]) ?></h3>
				<h5><small><?= Html::encode(date('D d M, Y',strtotime($model->time))) ?></small></h5>									
			
				<p class=""><?= Html::encode($model->description) ?></p>
				<p>
				<?= Html::a(Yii::t('app','Download'),$model->file,['class'=>'btn btn-small btn-default',"target"=>"blank"]) ?>			
				</p>
			</div>		
		</div>
	</div>

<?php
	if (($index+1) % 3 == 0)
	{
		echo '</div><div class="clearfix visible-sm-block">';	
	}
	
	if (($index+1) % 4 == 0)
	{
		echo '</div><div class="clearfix visible-md-block visible-lg-block">';	
	}
?>
