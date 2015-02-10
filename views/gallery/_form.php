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

// kcfinder options
// http://kcfinder.sunhater.com/install#dynamic
$kcfOptions = array_merge([], [
    'uploadURL' => Yii::getAlias('@web').'/upload',
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
]);

// Set kcfinder session options
Yii::$app->session->set('KCFINDER', $kcfOptions);


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

			<?= $form->field($model, 'description')->textArea(['maxlength' => 155,'placeholder'=>Yii::t('app','This description also used as meta description')]) ?>			
			
			<?= $form->field($model, 'tags')->widget(Select2::classname(), [
				'options' => [
					'placeholder' => Yii::t('app','Put additional tags ...'),
				],
				'pluginOptions' => [
					'tags' => $model->getTags(),
				],
			]) ?>					
		</div>	
		
		<div class="col-md-6 well">
			<?= $form->field($model, 'time')->widget(DateTimePicker::classname(), [				
					'options' => ['placeholder' => 'Select media time ...'],
					'convertFormat' => true,
					'pluginOptions' => [
						'format' => 'yyyy-MM-dd HH:i:s',
						//'startDate' => '01-Mar-2014 12:00 AM',
						'todayHighlight' => true
					]
				]) 
			?>
			
			<?php 
				echo $form->field($model, 'url')->widget(KCFinderInputWidget::className(), [
					'multiple' => false,
					'kcfOptions'=>$kcfOptions,	
					'kcfBrowseOptions'=>[
						'type'=>'image'				
					]	
				]);	
			?>							
			
			<?/*= $form->field($model, 'type')->textInput() */?>
		</div>	
    </div>	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
