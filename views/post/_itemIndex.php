<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model amilna\cap\models\AccountCode */

?>

	<div class="thumbnail">	
		<?php
			if ($model->image != null)
			{
		?>
			<img src="<?= $model->image ?>" alt="<?= $model->title ?>">
		<?php		
			}
		?>									
		<div class="caption">
			<h3><?= Html::a($model->title,["//blog/post/view?id=".$model->id]) ?></h3>
			<h4><?= $model->author->username ?> <small><?= date('D d M, Y',strtotime($model->time)) ?></small></h4>								
		
			<p><?= $model->description ?></p>
			<p>
			<?= Html::a(Yii::t('app','Read More'),["//blog/post/view?id=".$model->id],['class'=>'btn btn-small btn-default']) ?>			
			</p>		
		</div>
	</div>

