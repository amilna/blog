<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model amilna\cap\models\AccountCode */
$module = Yii::$app->getModule('blog');
?>

	<div class="thumbnail">	
	
		<div style="<?=($model->image != null?"background-size:cover;background-image:url('".str_replace($module->uploadURL."/",$module->uploadURL."/.thumbs/",$model->image)."')":"")?>" >
		<?php
			if ($model->image != null)
			{
				//echo Html::tag("div","",["style"=>'height:100%;width:100px;background-size:cover;background-image:url("'.str_replace($module->uploadURL."/",$module->uploadURL."/.thumbs/",$model->image).'")']);
		/*?>
			<img src="<?= str_replace($module->uploadURL."/",$module->uploadURL."/.thumbs/",$model->image) ?>" alt="<?= $model->title ?>" style="float:left;padding: 0 5px 5px 0;">
		<?php		*/
			}
		?>									
			<div class="caption text-left"  style="margin:0px 0px 0px <?=($model->image != null?"30%":"0px")?>;background:#ffffff;padding:20px;">
				<h3><?= Html::a($model->title,["//blog/post/view","id"=>$model->id,"title"=>$model->title]) ?></h3>
				<h5><?= Html::encode($model->author?$model->author->username:"") ?> <small><?= Html::encode(date('D d M, Y',strtotime($model->time))) ?></small></h5>									
			
				<p class=""><?= Html::encode($model->description) ?></p>
				<p>
				<?= Html::a(Yii::t('app','Read More'),["//blog/post/view","id"=>$model->id,"title"=>$model->title],['class'=>'btn btn-small btn-default']) ?>			
				</p>
			</div>		
		</div>
	</div>

<?php
	if (($index+1) % 2 == 0)
	{
		echo '</div><div class="clearfix visible-sm-block">';	
	}
	if (($index+1) % 3 == 0)
	{
		echo '</div><div class="clearfix visible-md-block visible-lg-block">';	
	}
?>
