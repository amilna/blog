<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use amilna\yap\GridView;
use amilna\blog\models\Post;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Posts');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/default']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Post',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false		
		'caption'=>Yii::t('app', 'Post'),
		'headerRowOptions'=>['class'=>'kartik-sheet-style','style'=>'background-color: #fdfdfd'],
		'filterRowOptions'=>['class'=>'kartik-sheet-style skip-export','style'=>'background-color: #fdfdfd'],
		'pjax' => false,
		'bordered' => true,
		'striped' => true,
		'condensed' => true,
		'responsive' => true,
		'hover' => true,
		'showPageSummary' => true,
		'pageSummaryRowOptions'=>['class'=>'kv-page-summary','style'=>'background-color: #fdfdfd'],
		
		'panel' => [
			'type' => GridView::TYPE_DEFAULT,
			'heading' => false,
		],
		'toolbar' => [
			['content'=>				
				Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'], ['data-pjax'=>false, 'class' => 'btn btn-default', 'title'=>Yii::t('app', 'Reset Grid')])
			],
			'{export}',
			'{toggleData}'
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
		
		/* uncomment to use megeer some columns
        'mergeColumns' => ['Column 1','Column 2','Column 3'],
        'type'=>'firstrow', // or use 'simple'
        */
        
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'id',
            [
				'attribute' => 'search',
				'value' => 'title',
            ],            
            'description',
            //'content:ntext',
            'tags',
            [
				'attribute' => 'author',
				'value' => 'author.username',
            ],            
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
				'attribute'=>'isfeatured',				
				'value'=>function($data){										
					return $data->itemAlias('isfeatured',$data->isfeatured?1:0);
				},
				'filterType'=>GridView::FILTER_SELECT2,				
				'filterWidgetOptions'=>[
					'data'=>$searchModel->temAlias('isfeatured'),
					'options' => ['placeholder' => Yii::t('app','Is Featured?')],
					'pluginOptions' => [
						'allowClear' => true
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
            // 'image:ntext',
            // 'author_id',
            
            
            
            // 'isdel',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>

</div>
