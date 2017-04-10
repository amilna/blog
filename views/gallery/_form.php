<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use kartik\money\MaskMoney;
use kartik\widgets\Select2;
use kartik\widgets\SwitchInput;
use kartik\datetime\DateTimePicker;

use iutbay\yii2kcfinder\KCFinderInputWidget;

$module = Yii::$app->getModule('blog');
if ($module->enableUpload)
{
	// kcfinder options
	// http://kcfinder.sunhater.com/install#dynamic
	$kcfOptions = array_merge([], [
		'uploadURL' => Yii::getAlias($module->uploadURL),
		'uploadDir' => Yii::getAlias($module->uploadDir),
		'access' => [
			'files' => [
				'upload' => true,
				'delete' => true,
				'copy' => true,
				'move' => true,
				'rename' => true,
			],
			'dirs' => [
				'create' => true,
				'delete' => true,
				'rename' => true,
			],
		],  
		'types'=>[
			'files'    =>  "",        
			'images'   =>  "*img",
			'videos'   =>  "ogg flv mp4",
		],
		'thumbWidth' => 260,
		'thumbHeight' => 260,              
	]);

	// Set kcfinder session options
	Yii::$app->session->set('KCFINDER', $kcfOptions);
}

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Gallery */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="gallery-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">				
		<div class="col-md-6">
			
			<div class="row">				
				<div class="col-xs-8">
			<?= $form->field($model, 'title')->textInput(['maxlength' => 65,'placeholder'=>Yii::t('app','Title contain a seo keyword if possible')]) ?>
				</div>
				<div class="col-xs-4">
			<?= $form->field($model, 'status')->widget(SwitchInput::classname(), [			
					'type' => SwitchInput::CHECKBOX,				
				]);
			?>		
				</div>						
			</div>

			<?= $form->field($model, 'description')->textArea(['rows'=>4,'maxlength' => 155,'placeholder'=>Yii::t('app','This description also used as meta description')]) ?>			
			
			<?= $form->field($model, 'tags')->widget(Select2::classname(), [
				'options' => [
					'placeholder' => Yii::t('app','Put additional tags ...'),
				],
				'data'=>$model->getTags(),
				'pluginOptions' => [
					'tags' => true,
					'tokenSeparators'=>[',',' '],
				],
			]) ?>					
		</div>	
		
		<div class="col-md-6">
			<div class="well">
			<?= $form->field($model, 'time')->widget(DateTimePicker::classname(), [				
					'options' => ['placeholder' => 'Select media time ...','readonly'=>true],
					'removeButton'=>false,
					'convertFormat' => true,
					'pluginOptions' => [
						'format' => 'yyyy-MM-dd HH:i:s',
						//'startDate' => '01-Mar-2014 12:00 AM',
						'todayHighlight' => true
					]
				]) 
			?>
			
			<?php
			
				$field = $form->field($model,"type");				
				echo $field->widget(Select2::classname(),[								
					'data' => $model->itemAlias("type"),								
					'options' => [
						'placeholder' => Yii::t('app','Select type ...'), 
						'multiple' => false
					],
				]);
			?>
			
			<div class="row">
				<div class="col-md-12">
				<?php 
					if ($module->enableUpload)
					{
						echo $form->field($model, 'image')->widget(KCFinderInputWidget::className(), [
							'multiple' => false,
							'kcfOptions'=>$kcfOptions,	
							'kcfBrowseOptions'=>[
								'type'=>'images',
								'lng'=>substr(Yii::$app->language,0,2),				
							]	
						]);	
					}
					else
					{
						echo $form->field($model, 'image')->textInput(['placeholder'=>Yii::t('app','Url of image')]);
					}
				?>							
				</div>
				<div id="videos" class="col-md-12" style="<?= $model->type == 0?"display:none;":""?>">
					<div class="well">
				<?php 	
					echo $form->field($model, 'url')->textInput(['placeholder'=>Yii::t('app','Url of youtube or uploaded movie')]);
					
					if ($module->enableUpload)
					{					
						echo KCFinderInputWidget::widget([
							'name'=>'videos_url',
							'multiple' => false,
							'kcfOptions'=>$kcfOptions,	
							'kcfBrowseOptions'=>[
								'type'=>'videos',
								'lng'=>substr(Yii::$app->language,0,2),				
							],					
						]);	
					}
				?>
					</div>					
				</div>
			</div>
						
			</div>	
		</div>	
    </div>	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
					

<script type="text/javascript">
	
<?php $this->beginBlock('VIDEOS') ?>			

function baseName(str,wext)
{
	var base = new String(str).substring(str.lastIndexOf('/') + 1); 
	if(base.lastIndexOf(".") != -1 && typeof wext == "undefined") {
		base = base.substring(0, base.lastIndexOf("."));		
	}    
	return base;
}

$("#gallery-type").change(function() {	
	$("#videos").css("display",($(this).val() == 1?"":"none"));	
});

$('#videos .kcf-thumbs').bind("DOMSubtreeModified",function(){	
	var sel = $('#videos .kcf-thumbs input[name=videos_url]');
	var url = "";
	if (sel.length > 0 && $('#videos .kcf-thumbs').html().replace(/ /g,"") != "")
	{
		url = sel.val();
		$('#filesrc .kcf-thumbs img').each(function(i,img){
			var src = $(img).attr("src");
			var ext = baseName(src);
			if (ext != 'flv')
			{
				$(img).attr("src",src.replace(ext+".png","flv.png"));
			}			
		});
	}	
	$('#gallery-url').val(url);
});


var video = "<?= $model->url?>";
var thumb = "<?= Yii::$app->assetManager->getPublishedUrl((new \iutbay\yii2kcfinder\KCFinderAsset)->sourcePath) ?>/themes/default/img/files/big/flv.png";
if (video != "")
{
	var html = '<li class="sortable ui-sortable-handle"><div class="remove"><span class="fa fa-trash"></span></div><img src="'+thumb+'"><input type="hidden" name="videos_url" value="'+video+'"></li>';	
	$("#videos .kcf-thumbs").html(html);
	$('#gallery-url').val(video);		
}

	
<?php $this->endBlock(); ?>

</script>
<?php
yii\web\YiiAsset::register($this);
$this->registerJs($this->blocks['VIDEOS'], yii\web\View::POS_END);
