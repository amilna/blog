<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model amilna\cap\models\AccountCode */

?>

	<div class="thumbnail">	
	
		<div style="<?=($model->image != null?"background-size:cover;background-image:url('".str_replace("/upload/","/upload/.thumbs/",$model->image)."')":"")?>" >
		<?php
			if ($model->image != null)
			{
				//echo Html::tag("div","",["style"=>'height:100%;width:100px;background-size:cover;background-image:url("'.str_replace("/upload/","/upload/.thumbs/",$model->image).'")']);
		/*?>
			<img src="<?= str_replace("/upload/","/upload/.thumbs/",$model->image) ?>" alt="<?= $model->title ?>" style="float:left;padding: 0 5px 5px 0;">
		<?php		*/
			}
		?>									
			<div class="caption text-left"  style="margin:0px 0px 0px <?=($model->image != null?"150px":"0px")?>;background:#ffffff;padding:20px;">
				<h3><?= Html::a($model->title,["//blog/post/view?id=".$model->id]) ?></h3>
				<h5><?= $model->author->username ?> <small><?= date('D d M, Y',strtotime($model->time)) ?></small></h5>									
			
				<p class=""><?= $model->description ?></p>
				<p>
				<?= Html::a(Yii::t('app','Read More'),["//blog/post/view?id=".$model->id],['class'=>'btn btn-small btn-default']) ?>			
				</p>
			</div>		
		</div>
	</div>

