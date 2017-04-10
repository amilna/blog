<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ListView;
use amilna\yap\GridView;
use amilna\yap\SequenceJs;


/* @var $this yii\web\View */
/* @var $searchModel amilna\blog\models\BannerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Banners');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Blog'), 'url' => ['/blog/default']];
$this->params['breadcrumbs'][] = $this->title;

$module = Yii::$app->getModule('blog');
?>
<style>
td img {
	max-width:200px!important;	
}
</style>
<div class="banner-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>                               
    
    <?php 
    // add echo to print
        
    SequenceJs::widget([
			'dataProvider'=>$bannerProvider, // active data provider
			'targetId'=>'sequence',	//id of rendered sequencejs (the container will constructed by the widget with the given id)
			'imageKey'=>'front_image', //model attribute to be used as image
			'backgroundKey'=>'image', //model attribute to be used as background
			'theme' => 'modern', //available themes: default, parallax, modern			
			'options'=>[
					'pagination'=> true,
					'autoPlay'=> true,
					'autoPlayDelay'=> 3000,
					'cycle'=>true,										
					'preloader'=> true,				
				],
			
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
				
			'itemView'=>function ($model, $key, $widget) {											
							$html = '<li style="background-image:url('.$model->image.');'.(!empty($model->url)?'cursor:pointer;':'').'" '.(!empty($model->url)?'data-url="'.(substr($model->url,0,4) == "http"?$model->url:Yii::$app->urlManager->createUrl($model->url)).'"':'').'>
										'.(!$model->image_only?'			
										<h2 class="title">'.Html::encode($model->title).'</h2>						
										<h3 class="subtitle">'.Html::encode($model->description).'</h3>':'').'
										<img class="model" src="'.($model->front_image == null?"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNgYAAAAAMAASsJTYQAAAAASUVORK5CYII=":$model->front_image).'" />								
									</li>';						
											
							return $html;
						},
			'itemPager' => function ($model, $key, $widget) {											
							$html = '<li><img src="'.$model->image.'" alt="'.$key.'" style="max-width:40px;max-height:40px;"/></li>';										
							return $html;
						},
																	
		]);
    
    /* 
    
    //another example use parallax theme
        
	echo SequenceJs::widget([
		'dataProvider'=>$bannerProvider, // active data provider
		'targetId'=>'sequence',	//id of rendered sequencejs (the container will constructed by the widget with the given id)
		'imageKey'=>'front_image', //model attribute to be used as image
		'backgroundKey'=>'image', //model attribute to be used as background
		'theme' => 'parallax', //available themes: default, parallax, modern
		
		//'css' => 'test.css', // url of css to overide default css relative from @web
		
		// example to overide default themes
		'itemView'=>function ($model, $key, $widget) {					
						$type = ['aeroplane','balloon','kite'];
						$html = '<li>'.($model->image_only?"":'
									<div class="info">
										<h2>'.$model->title.'</h2>
										<p>'.$model->description.'</p>
									</div>').'
									<img class="sky" src="'.$model->image.'" alt="Blue Sky" />
									<img class="'.$type[$key%3].'" src="'.$model->front_image.'" alt="Aeroplane" />
								</li>';
										
						return $html;
					},		 				
		
	]) 
	*/ 
	
	?>  
	            

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false		
		//'caption'=>Yii::t('app', 'Banner'),
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
			'heading' => '<i class="glyphicon glyphicon-th-list"></i>  '.Yii::t('app', 'Banner'),			
			'before'=>Html::a(
					'<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Create'),
					['create'], 
					[	'class' => 'btn btn-success', 
						'title'=>Yii::t('app', 'Create {modelClass}', [
							'modelClass' => Yii::t('app','Banner'),
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
		/*uncomment to use merger some columns
        'mergeColumns' => ['Column 1','Column 2','Column 3'],
        'type'=>'firstrow', // or use 'simple'
        */
        
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
				'attribute' => 'term',
				'format'=>'html',
				'value' => function($data) use ($module) {
					$html = Html::img(str_replace($module->uploadURL."/",$module->uploadURL."/.thumbs/",$data->image),['class'=>'pull-left','style'=>'margin:0px 10px 10px 0px;']);
					if (!empty($data->front_image))
					{
						$html .= Html::img(str_replace($module->uploadURL."/",$module->uploadURL."/.thumbs/",$data->front_image),['class'=>'pull-left','style'=>'margin:0px 10px 10px 0px;']);
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
