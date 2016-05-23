<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use amilna\yap\GridView;

/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/default']];
$this->params['breadcrumbs'][] = $this->title;

$module = Yii::$app->getModule('blog');
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false		
		//'caption'=>Yii::t('app', 'Category'),
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
			'heading' => '<i class="glyphicon glyphicon-th-list"></i>  '.Yii::t('app', 'Category'),			
			'before'=>Html::a(
					'<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create'),
					['create'], 
					[	'class' => 'btn btn-success', 
						'title'=>Yii::t('app', 'Create {modelClass}', [
							'modelClass' => Yii::t('app','Category'),
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
            
            'title',
            [				
				'attribute'=>'parent_id',				
				'value'=>'parent.title',
				'filterType'=>GridView::FILTER_SELECT2,				
				'filterWidgetOptions'=>[
					'data'=>ArrayHelper::map($searchModel->parents(),"id","title"),
					'options' => ['placeholder' => Yii::t('app','Select a parent category...')],
					'pluginOptions' => [
						'allowClear' => true
					],
					
				],
            ],
            'description:ntext',
            [
				'attribute' => 'image',
				'format'=>'html',
				'value' => function($data) use ($module) {
					return ($data->image!= null?Html::img(str_replace("/".$module->uploadDir."/","/".$module->uploadDir."/.thumbs/",$data->image),['class'=>'pull-left','style'=>'margin:0 10px 10px 0']):'');
				},
            ],            
            // 'status:boolean',
            // 'isdel',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>

</div>
