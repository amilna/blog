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

/* @var $this yii\web\View */
/* @var $model amilna\blog\models\Category */
/* @var $form yii\widgets\ActiveForm */

$listParent = []+ArrayHelper::map(($model->isNewRecord?$model->parents():$model->parents($model->id)), 'id', 'title');
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
		<div class="col-md-6">
    <?= $form->field($model, 'title')->textInput(['maxlength' => 65]) ?>   

    <?= $form->field($model, 'description')->textarea(['rows' => 3]) ?>    
    
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

    <?= $form->field($model, 'status')->widget(SwitchInput::classname(), [			
			'type' => SwitchInput::CHECKBOX,				
		]);
	?>			
		</div>
		<div class="col-md-6">
	<?= $form->field($model, 'image')->textInput(['maxlength' => 255]) ?>		
		</div>
	</div>
	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
