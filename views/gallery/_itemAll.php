<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Gallery */

$module = Yii::$app->getModule('blog');

$this->params['cboxTarget']['.gallery_colorbox'] =  [
													'maxWidth' => 800,
													'maxHeight' => 600,
													'rel'=>'gallery_colorbox',
													'slideshow'=>true
												];

$this->params['cboxTarget']['.hgallery_colorbox'] =  [
													'maxWidth' => 800,
													'maxHeight' => 600,
													'rel'=>'hgallery_colorbox',
													'slideshow'=>true
												];
												
$gdd = Yii::$app->assetManager->getPublishedUrl((new \amilna\blog\assets\FlowAsset)->sourcePath);
												
if ($model["type"] == 1 )
{
	$this->params['cboxTarget']['.gallery_colorbox'.$model["id"]] =  [
													'innerWidth' => 640,
													'innerHeight' => 390,
													//'rel'=>'gallery_colorbox'.$model["id"],
													//'slideshow'=>false,
													'iframe' => true
												];

	$this->params['cboxTarget']['.hgallery_colorbox'.$model["id"]] =  [
													'innerWidth' => 640,
													'innerHeight' => 390,
													//'rel'=>'hgallery_colorbox'.$model["id"],
													//'slideshow'=>false,
													'iframe' => true
												];
													
}


?>

	<div class="thumbnail">
		<div class="col-xs-12" style="background-color:black;margin-bottom:10px;">
			<div class="row">
			
			<?php				
				if (count($model['data']) == 1 && $model["type"] > (-1) )
				{
					$class = 'gallery_colorbox'.($model["type"] == 1?$model["id"]:"");
					$imgclass = "col-xs-12 nopadding";
					
					
					if ($model["type"] == 1)
					{
						$model["url"] = (substr($model["url"],0,4) == "http"?$model["url"]:$gdd."?url=".$model["url"]."&image=".$model['data'][0]."&auto=true");
					}
					
					$url = ($model["type"] == 1?$model["url"]:$model['data'][0]);
					$durl = $url;
				}
				else
				{
					$class = "";
					$imgclass = "nopadding col-xs-".(12/pow(2,(count($model['data'])-1)/max(1,(count($model['data'])-1))));
					$durl= ["//blog/gallery/index","tag"=>strtolower($model['title'])];
					$url = Yii::$app->urlManager->createUrl($durl);
				}
			?>
			<a href="<?= $url ?>" class="<?= $class ?>" title="<?= $model['title'] ?>">
		<?php							
			if ($model["type"] == 1)
			{
				//echo "<iframe align=middle frameborder=0 seamless=true width=100% height=100% class='".$imgclass."' style='max-height:100px:' src='".str_replace("&auto=true","&auto=false",$url)."'></iframe>";					
				echo Html::img(str_replace($module->uploadURL."/",$module->uploadURL."/.thumbs/",$model['data'][0]),['class'=>$imgclass]);				
			}
			else
			{
				$n = 0;						
				foreach ($model['data'] as $data)
				{
					$n += 1;
					echo Html::img(str_replace($module->uploadURL."/",$module->uploadURL."/.thumbs/",$data),['class'=>$imgclass]);				
				}
			}	
		?>	
			</a>		
			</div>			
		</div>			
										
		<div class="caption">			
			<h4><?= $model["type"] == 1?'<i class="fa fa-film"></i>':''?> <?= Html::a($model['title'],$durl,["class"=>'h'.$class]) ?></h4>
			<h5><?= $model['description'].(!empty($model['description'])?"<br>":"") ?>
			<small><?= $model['tags'] ?></small>
			</h5>
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
