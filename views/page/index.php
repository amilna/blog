<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use amilna\yap\GridView;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\StaticPageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Static Pages');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/default']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="static-page-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false		
		//'caption'=>Yii::t('app', 'Static Page'),
		'headerRowOptions'=>['class'=>'kartik-sheet-style','style'=>'background-color: #fdfdfd'],
		'filterRowOptions'=>['class'=>'kartik-sheet-style skip-export','style'=>'background-color: #fdfdfd'],
		'pjax' => true,
		'bordered' => true,
		'striped' => true,
		'condensed' => true,
		'responsive' => true,
		'responsiveWrap' => false,
		'hover' => true,
		'showPageSummary' => true,
		'pageSummaryRowOptions'=>['class'=>'kv-page-summary','style'=>'background-color: #fdfdfd'],
		'tableOptions'=>["style"=>"margin-bottom:100px;"],				
		'panel' => [
			'type' => GridView::TYPE_DEFAULT,
			'heading' => '<i class="glyphicon glyphicon-th-list"></i>  '.Yii::t('app', 'Static Page'),			
			'before'=>Html::a(
					'<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create'),
					['create'], 
					[	'class' => 'btn btn-success', 
						'title'=>Yii::t('app', 'Create {modelClass}', [
							'modelClass' => Yii::t('app','Static Page'),
						])
					]
				).' <em style="margin:10px;"><small>'.Yii::t('app', 'Type in column input below to filter, or click column title to sort').'</small></em>',
		],				
		'toolbar' => [			
			['content'=>								
				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>true, 'class' => 'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
			],
			'{export}',
			//'{toggleData}'
		],
		'beforeHeader'=>[
			[
				/* uncomment to use additional header
				'columns'=>[
					['content'=>'Group 1', 'options'=>['colspan'=>6, 'class'=>'text-center','style'=>'background-color: #fdfdfd']], 
					['content'=>'Group 2', 'options'=>['colspan'=>6, 'class'=>'text-center','style'=>'background-color: #fdfdfd']], 					
				],
				*/
				'options'=>['class'=>'skip-export'] // remove this row from export
			]
		],
		'floatHeader' => true,		
		'floatHeaderOptions'=>['position'=>'absolute','top'=>50],
		/*uncomment to use megeer some columns
        'mergeColumns' => ['Column 1','Column 2','Column 3'],
        'type'=>'firstrow', // or use 'simple'
        */
        
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
				'attribute' => 'term',
				'value' => 'title',
            ],            
            'description',
            //'content:ntext',
            'tags',                        
            [				
				'attribute' => 'time',
				'value' => 'time',				
				'filterType'=>GridView::FILTER_DATE_RANGE,
				'filterWidgetOptions'=>[
					'pluginOptions' => [
						'format' => 'YYYY-MM-DD HH:mm:ss',				
						'todayHighlight' => true,
						'timePicker'=>true,
						'timePickerIncrement'=>15,
						'opens'=>'left'
					],
					'pluginEvents' => [
					"apply.daterangepicker" => 'function() {									
									$(this).change();
								}',
					],			
				],
			],                        
            [				
				'attribute'=>'status',				
				'value'=>function($data){										
					return $data->itemAlias('status',$data->status);
				},
				'filterType'=>GridView::FILTER_SELECT2,				
				'filterWidgetOptions'=>[
					'data'=>$searchModel->itemAlias('status'),
					'options' => ['placeholder' => Yii::t('app','Filter by status...')],
					'pluginOptions' => [
						'allowClear' => true
					],
					
				],
            ],            
            // 'isdel',

            [
				'class' => 'kartik\grid\ActionColumn',				
				'buttons'=>[
					'view'=>function ($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',["view","id"=>$model->id,"title"=>$model->title],["title"=>Yii::t("yii","View")]);
					},						
				]
			],
        ],
    ]); ?>

</div>
