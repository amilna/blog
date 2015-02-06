<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model amilna\cap\models\AccountCode */

?>
<div class="col-md-4 col-sm-6">
	<div class="blog-post">
		<!-- Post Info -->
		<div class="post-info">
			<h4><?= $model->author->username ?> <small><?= date('D d M, Y',strtotime($model->time)) ?></small></h4>			
		</div>
		<!-- End Post Info -->
		<!-- Post Image -->
		<?php
			if ($model->image != null)
			{
		?>
			<img src="<?= $model->image ?>" alt="<?= $model->title ?>">
		<?php		
			}
		?>							
		<!-- End Post Image -->
		<!-- Post Title & Summary -->
		<div class="post-title">
			<h3><?= Html::a($model->title,["//blog/post/view?id=".$model->id]) ?></h3>
		</div>
		<div class="post-summary">
			<p><?= $model->description ?></p>
		</div>
		<!-- End Post Title & Summary -->
		<div class="post-more">
			<?= Html::a(Yii::t('app','Read More'),["//blog/post/view?id=".$model->id],['class'=>'btn btn-small']) ?>			
		</div>
	</div>
</div>
