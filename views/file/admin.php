<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use amilna\yap\GridView;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\FileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Files');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/default']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false		
		'caption'=>Yii::t('app', 'File'),
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
			'heading' => '<i class="glyphicon glyphicon-th-list"></i>  '.Yii::t('app', 'File'),			
			'before'=>Html::a(
					'<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create'),
					['create'], 
					[	'class' => 'btn btn-success', 
						'title'=>Yii::t('app', 'Create {modelClass}', [
							'modelClass' => Yii::t('app','File'),
						])
					]
				).' <em style="margin:10px;"><small>'.Yii::t('app', 'Type in column input below to filter, or click column title to sort').'</small></em>',
		],				
		'toolbar' => [			
			['content'=>								
				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['admin'], ['data-pjax'=>true, 'class' => 'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
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

            //'id',
            'title',
            'description',
            'tags',            
            [
				'attribute'=>'status',
				'value' => function($data){					
					return $data->itemAlias('status',$data->status?1:0);
				},				
				'filterType'=>GridView::FILTER_SELECT2,				
				'filterWidgetOptions'=>[
					'data'=>$searchModel->itemAlias('status'),
					'options' => ['placeholder' => Yii::t('app','Select a status type...')],
					'pluginOptions' => [
						'allowClear' => true
					],
					
				],
								
            ],
            [
				'attribute' => 'file',
				'format'=>'raw',				
				'value'=>function($data){										
					return Html::a(basename($data->file),$data->file,["class"=>"btn btn-xs btn-success btn-block","title"=>Yii::t("app","Click to download!"),"target"=>"blank"]);															
				},
            ],            
            
            // 'time',
            // 'isdel',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>

</div>
