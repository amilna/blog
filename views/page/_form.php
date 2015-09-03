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
use amilna\blog\models\Category;
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
/* @var $model amilna\blog\models\Post */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>
	<div class="row">
		<div class="col-md-9">
			<div class="row">				
				<div class="col-xs-12">
			<?= $form->field($model, 'title')->textInput(['maxlength' => 65,'placeholder'=>Yii::t('app','Title contain a seo keyword if possible')]) ?>
				</div>				
			</div>
			<?= $form->field($model, 'description')->textArea(['maxlength' => 155,'placeholder'=>Yii::t('app','This description also used as meta description')]) ?>

			<?php 
			$isettings = [
					'lang' => substr(Yii::$app->language,0,2),
					'minHeight' => 400,
					'toolbarFixedTopOffset'=>50,	
					'buttonSource'=> true,							
					'plugins' => [				
						'imagemanager',
						'filemanager',
						'video',
						'table',
						'clips',				
						'fullscreen'
					],
					'buttons'=> ['html','formatting', 'bold', 'italic','underline','deleted', 'unorderedlist', 'orderedlist',
					  'outdent', 'indent', 'image', 'file', 'link', 'alignment', 'horizontalrule'
					],
					'replaceDivs'=> false,
					'deniedTags'=> ['script']
				];
				
			if ($module->enableUpload)
			{
				$isettings = array_merge($isettings,[
								'imageUpload' => Url::to(['//blog/default/image-upload']),								
								'fileUpload' => Url::to(['//blog/default/file-upload']),
								'imageManagerJson' => Url::to(['//blog/default/images-get']),			
								'fileManagerJson' => Url::to(['//blog/default/files-get']),
							]);
			}	
			
			use vova07\imperavi\Widget;
			echo $form->field($model, 'content')->widget(Widget::className(), [
				'settings' => $isettings,
				'options'=>["style"=>"width:100%"]
			]);
			?>
			
			<?php if ($module->enableScriptsPage) { ?>				
			<?= $form->field($model, 'scripts')->textArea(['rows'=>6,'placeholder'=>Yii::t('app','JavaScripts')]) ?>
			<?php } ?>
		</div>
		<div class="col-md-3">
			<div class="well">
				<?= $form->field($model, 'time')->widget(DateTimePicker::classname(), [				
						'options' => ['placeholder' => 'Select posting time ...','readonly'=>true],
						'removeButton'=>false,
						'convertFormat' => true,
						'pluginOptions' => [
							'format' => 'yyyy-MM-dd HH:i:s',
							//'startDate' => '01-Mar-2014 12:00 AM',
							'todayHighlight' => true,							
						]
					]) 
				?>
		
				<?= $form->field($model, 'tags')->widget(Select2::classname(), [
					'options' => [
						'placeholder' => Yii::t('app','Put additional tags ...'),
					],
					'data'=>$model->getTags(),
					'pluginOptions' => [
						'tags' => true,
						'tokenSeparators'=>[','],
					],
				]) ?>										
				
				<?= $form->field($model, 'status')->widget(Select2::classname(), [			
						'data' => $model->itemAlias('status'),				
						'options' => ['placeholder' => Yii::t('app','Select post status...')],
						'pluginOptions' => [
							'allowClear' => false
						],
						'pluginEvents' => [
						],
					]);
				?>
								
			</div>				
		</div>
	</div>
       
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
