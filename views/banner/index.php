<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use amilna\yap\GridView;
use amilna\yap\widgets\SequenceJs;


/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Banners');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/default']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="banner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>                               
    
    <?= SequenceJs::widget([
		'dataProvider'=>$bannerProvider, // active data provider
		'targetId'=>'sequence',	//id of rendered sequencejs (the container will constructed by the widget with the given id)
		'imageKey'=>'front_image', //model attribute to be used as image
		'backgroundKey'=>'image', //model attribute to be used as background
		'theme' => 'parallax', //available themes: default, parallax, modern
		
		//'css' => 'test.css', // url of css to overide default css relative from @web
		
		/* example to overide default themes		
		'itemView'=>function ($model, $key, $widget) {					
						$type = ['aeroplane','balloon','kite'];
						$html = '<li>
									<div class="info">
										<h2>'.$model->title.'</h2>
										<p>'.$model->description.'</p>
									</div>
									<img class="sky" src="'.$model->image.'" alt="Blue Sky" />
									<img class="'.$type[$key%3].'" src="'.$model->front_image.'" alt="Aeroplane" />
								</li>';
										
						return $html;
					},
		 */
		
		/*	example to overide default options	more options on http://sequencejs.com 
		'options'=>[
				'autoPlay'=> true,
				'autoPlayDelay'=> 3000,
				'cycle'=>true,						
				'nextButton'=> true,
				'prevButton'=> true,
				'preloader'=> true,
				'navigationSkip'=> false
			],		
		 */
		 	
		/*	example to use widget without active data provider (the target selector should already rendered)
		'targets' => [
			'.sequencejs' => [
				'autoPlay'=> true,
				'autoPlayDelay'=> 3000,
				'cycle'=>true,						
				'nextButton'=> true,
				'prevButton'=> true,
				'preloader'=> true,
				'navigationSkip'=> false
			],
		],
		*/ 
		
	]) ?>    
    
    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
			'modelClass' => 'Banner',
		]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false		
		'caption'=>Yii::t('app', 'Banner'),
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

            [
				'attribute' => 'search',
				'format'=>'html',
				'value' => function($data){
					$html = Html::img(str_replace("/upload/","/upload/.thumbs/",$data->image),['class'=>'pull-left','style'=>'margin:0 10px 10px 0']);
					if (!empty($data->front_image))
					{
						$html .= Html::img(str_replace("/upload/","/upload/.thumbs/",$data->front_image),['class'=>'pull-left','style'=>'margin:0 10px 10px 0']);
					}
					return $html;
				},
            ],            
            'title',
            'description',            
            'tags',
            'position',
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
            // 'time',
            // 'isdel',

            ['class' => 'kartik\grid\ActionColumn'],
        ],
    ]); ?>

</div>
