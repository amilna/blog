<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use amilna\blog\models\Category;

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'title', 'content' => Html::encode($model->title)]);
$this->registerMetaTag(['name' => 'description', 'content' => Html::encode($model->description)]);

$cat = new Category();
?>
<div class="post-view">

    <h1><?= Html::encode($this->title) ?></h1>    

	<div class="row">
		<!-- Blog Post -->
		<div class="col-sm-8 panel">
			<div class="panel-body">
				<div>
					<h3><?= Html::encode($model->author?$model->author->username:"") ?> <small><i class="glyphicon glyphicon-time"></i>  <?= date('D d M, Y',strtotime($model->time)) ?> </small></h3>
				</div>				
				<div>
					<?php
						if ($model->image != null)
						{
							echo Html::img($model->image,["style"=>"width:100%;margin-bottom:20px;","alt"=>$model->title]);					
						}
					?>					
				</div>
				<div>
					<?= HtmlPurifier::process($model->content,[
						'HTML.SafeIframe'=>true,
						'URI.SafeIframeRegexp'=>'%^http(s)?://(www.youtube.com/embed/|player.vimeo.com/video/|'.str_replace(['http://','https://'],'',Yii::getAlias('@web')).')%'
					]) ?>
					
				</div>				
			</div>
		</div>
		<!-- End Blog Post -->
		<!-- Sidebar -->
		<div class="col-sm-4">
			<?php /*
			<p>
				<?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
				<?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
					'class' => 'btn btn-danger',
					'data' => [
						'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
						'method' => 'post',
					],
				]) ?>
			</p>
			*/ ?> 
			<h4><?= Yii::t("app","Search our Posts")?></h4>
			
			<form action="<?=Yii::$app->urlManager->createUrl("//blog/post")?>" method="get">
				<div class="input-group">
					<input class="form-control input-md" name="PostSearch[term]" id="appendedInputButtons" type="text">
					<span class="input-group-btn">
						<button class="btn btn-md" type="submit">Search</button>
					</span>
				</div>
			</form>
			<hr>
			<h4><?= Yii::t("app","Recent Posts")?></h4>
			<ul class="list-unstyled">
				<?php
					foreach ($model->getRecent() as $m)
					{
						echo '<li>'.Html::a($m->title,["//blog/post/view","id"=>$m->id,"title"=>$m->title]).'</li>';
					}				
				?>		
			</ul>
			<hr>
			<h4><?= Yii::t("app","Categories")?></h4>
			<ul class="nav nav-pills nav-stacked">
				<?php
					foreach ($cat->parents() as $c)
					{
						echo '<li>'.Html::a($c->title,["//blog/post/index","category"=>$c->title]).'</li>';
					}				
				?>						
			</ul>
			<hr>
			<h4><?= Yii::t("app","Archive")?></h4>
			<ul class="nav nav-pills">
				<?php
					foreach ($model->getArchived() as $m)
					{
						echo '<li>'.Html::a(date('M Y',strtotime($m["month"])),["//blog/post/index","time"=>$m["month"]]).'</li>';
					}				
				?>				
			</ul>			
		</div>
		<!-- End Sidebar -->
	</div>

</div>
