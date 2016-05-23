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
		'thumbWidth' => 200,
		'thumbHeight' => 200,              
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
					'multiple'=>true,
					'tokenSeparators'=>[','],
				],
			]) ?>					
		</div>	
		
		<div class="col-md-6">
			<div class="well">
			<?= $form->field($model, 'time')->widget(DateTimePicker::classname(), [				
					'options' => ['placeholder' => 'Select file time ...','readonly'=>true],
					'removeButton'=>false,
					'convertFormat' => true,
					'pluginOptions' => [
						'format' => 'yyyy-MM-dd HH:i:s',						
						'todayHighlight' => true
					]
				]) 
			?>
						
			
			<div class="row">
				<div class="col-md-12">
				<?php 
					if ($module->enableUpload)
					{
						echo $form->field($model, 'file')->widget(KCFinderInputWidget::className(), [
							'multiple' => false,
							'kcfOptions'=>$kcfOptions,	
							'kcfBrowseOptions'=>[
								'type'=>'files',
								'lng'=>substr(Yii::$app->language,0,2),				
							]	
						]);	
					}
					else
					{
						echo $form->field($model, 'file')->textInput(['placeholder'=>Yii::t('app','Url of file')]);		
					}
				?>							
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
