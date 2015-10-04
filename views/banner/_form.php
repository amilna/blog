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
use kartik\touchspin\TouchSpin;

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
		],
		'thumbWidth' => 200,
		'thumbHeight' => 200,        
	]);

	// Set kcfinder session options
	Yii::$app->session->set('KCFINDER', $kcfOptions);
}

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Banner */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banner-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">				
		<div class="col-md-6">
			
			<div class="row">				
				<div class="col-xs-12">
			<?= $form->field($model, 'title')->textInput(['maxlength' => 65,'placeholder'=>Yii::t('app','Title contain a seo keyword if possible')]) ?>
				</div>				
			</div>

			<?= $form->field($model, 'description')->textArea(['maxlength' => 155,'placeholder'=>Yii::t('app','This description also used as meta description')]) ?>			
			<?= $form->field($model, 'url')->textInput(['maxlength' => 255,'placeholder'=>Yii::t('app','Link attached to the banner.. (start with http for external link)')]) ?>
			
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
				<div class="row">
					<div class="col-xs-6">
				<?= $form->field($model, 'status')->widget(SwitchInput::classname(), [			
						'type' => SwitchInput::CHECKBOX,				
					]);
				?>		
					</div>						
					<div class="col-xs-6">
				<?= $form->field($model, 'image_only')->widget(SwitchInput::classname(), [			
						'type' => SwitchInput::CHECKBOX,				
					]);
				?>		
					</div>				
				</div>			
				<div class="row">
					<div class="col-sm-6 ">
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
					</div>
					<div class="col-sm-6 ">
						<?= $form->field($model, 'position')->widget(TouchSpin::classname(), [
								//'sliderColor'=>Slider::TYPE_GREY,
								//'handleColor'=>Slider::TYPE_PRIMARY,
								'pluginOptions'=>[
									'min'=>0,
									'max'=>20,
									'step'=>1,
									'handle'=>'triangle',
									'tooltip'=>'always'
								]
							])
						?>
					</div>	
				</div>		
				<div class="row">
					<div class="col-sm-6 ">
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
					<div class="col-sm-6 ">	
						<?php
							if ($module->enableUpload)
							{
								echo $form->field($model, 'front_image')->widget(KCFinderInputWidget::className(), [
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
								echo $form->field($model, 'front_image')->textInput(['placeholder'=>Yii::t('app','Url of image')]);
							}
						?>	
					</div>
				</div>	
			
				<?php /* echo $form->field($model, 'type')->textInput(); */?>
			</div>
		</div>	
    </div>		    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
