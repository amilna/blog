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
				'delete' => false,
				'copy' => false,
				'move' => false,
				'rename' => false,
			],
			'dirs' => [
				'create' => true,
				'delete' => false,
				'rename' => false,
			],
		],    
		'types'=>[
			'files'    =>  "",        
			'images'   =>  "*img",
		],
		'thumbWidth' => 260,
		'thumbHeight' => 260,            
	]);

	// Set kcfinder session options
	Yii::$app->session->set('KCFINDER', $kcfOptions);

}

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Category */
/* @var $form yii\widgets\ActiveForm */

$listParent = []+ArrayHelper::map(($model->isNewRecord?$model->parents():$model->parents($model->id)), 'id', 'title');
?>

<div class="category-form">

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

			<?= $form->field($model, 'description')->textArea(['maxlength' => 155,'placeholder'=>Yii::t('app','This description also used as meta description')]) ?>			
						
		</div>	
		
		<div class="col-md-6 well">
			<?= $form->field($model, 'parent_id')->widget(Select2::classname(), [
				'model'=>$model,
				'attribute'=>'parent_id',
				'data' => $listParent,				
				'options' => ['placeholder' => Yii::t('app','Select a account parent...')],
				'pluginOptions' => [
					'allowClear' => true
				],
				'pluginEvents' => [
					"change" => 'function() { 														
								}',			
				],
			]);?>   
			
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
			
			<?php
				/*= $form->field($model, 'type')->textInput() */
			?>
		</div>	
    </div>	
	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
