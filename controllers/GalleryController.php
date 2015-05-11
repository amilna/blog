<?php

namespace amilna\blog\controllers;

use Yii;
use amilna\blog\models\Gallery;
use amilna\blog\models\GallerySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GalleryController implements the CRUD actions for Gallery model.
 */
class GalleryController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Gallery models.
     * @params string $format, array $arraymap, string $term
     * @return mixed
     */
    public function actionIndex($format= false,$arraymap= false,$term = false,$tag = false)
    {
        $searchModel = new GallerySearch();        
        $req = Yii::$app->request->queryParams;
        if ($term) { 
			$req[basename(str_replace("\\","/",get_class($searchModel)))]["term"] = $term;			
        }        
        if ($tag) { 
			$req[basename(str_replace("\\","/",get_class($searchModel)))]["tag"] = $tag;			
        }        
        $req[basename(str_replace("\\","/",get_class($searchModel)))]["status"] = 1;
        $dataProvider = $searchModel->search($req);				

        if ($format == 'json')
        {
			$model = [];
			foreach ($dataProvider->getModels() as $d)
			{
				$obj = $d->attributes;
				if ($arraymap)
				{
					$map = explode(",",$arraymap);
					if (count($map) == 1)
					{
						$obj = (isset($d[$arraymap])?$d[$arraymap]:null);
					}
					else
					{
						$obj = [];					
						foreach ($map as $a)
						{
							$k = explode(":",$a);						
							$v = (count($k) > 1?$k[1]:$k[0]);
							$obj[$k[0]] = ($v == "Obj"?json_encode($d->attributes):(isset($d->$v)?$d->$v:null));
						}
					}
				}
				
				if ($term)
				{
					if (!in_array($obj,$model))
					{
						array_push($model,$obj);
					}
				}
				else
				{	
					array_push($model,$obj);
				}
			}			
			return \yii\helpers\Json::encode($model);	
		}
		else
		{					
			
		
			$tags=[];
			$items=[];
			$n = 0;
			$model = [];
			foreach ($dataProvider->getModels() as $data)
			{
				if (!empty($data->tags) && (!isset($req['GallerySearch']['tag'])))
				{					
					foreach(explode(",",$data->tags) as $tag)
					{
						if (!isset($tags[strtolower($tag)]))
						{
							$n += 1;
							$tags[strtolower($tag)]=array('id'=>$n,'data'=>array(),'url'=>$data->url,'type'=>-1,'tags'=>$tag,'title'=>ucwords($tag),'description'=>$data->description);
							array_push($tags[strtolower($tag)]['data'],$data->image);
						}
						else
						{
							if (count($tags[strtolower($tag)]['data']) < 4)
							{
								array_push($tags[strtolower($tag)]['data'],$data->image);
							}
						}
					}
				}
				else
				{
					if (!isset($items[$data->id]))
					{
						$n += 1;
						$items[$data->id]=array('id'=>$n,'data'=>array(0=>$data->image),'url'=>$data->url,'type'=>$data->type,'tags'=>$data->tags,'title'=>$data->title,'description'=>$data->description);
					}							
				}
				
			}
			$albums = array_merge($tags,$items);
		
		
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'albums' => $albums,
			]);
		}	
    }
    
    public function actionAdmin($format= false,$arraymap= false,$term = false)
    {
        $searchModel = new GallerySearch();        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams+($term?['GallerySearch'=>['search'=>$term]]:[]));

        if ($format == 'json')
        {
			$model = [];
			foreach ($dataProvider->getModels() as $d)
			{
				$obj = $d->attributes;
				if ($arraymap)
				{
					$map = explode(",",$arraymap);
					if (count($map) == 1)
					{
						$obj = (isset($d[$arraymap])?$d[$arraymap]:null);
					}
					else
					{
						$obj = [];					
						foreach ($map as $a)
						{
							$k = explode(":",$a);						
							$v = (count($k) > 1?$k[1]:$k[0]);
							$obj[$k[0]] = ($v == "Obj"?json_encode($d->attributes):(isset($d->$v)?$d->$v:null));
						}
					}
				}
				
				if ($term)
				{
					if (!in_array($obj,$model))
					{
						array_push($model,$obj);
					}
				}
				else
				{	
					array_push($model,$obj);
				}
			}			
			return \yii\helpers\Json::encode($model);	
		}
		else
		{
			return $this->render('admin', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}	
    }

    /**
     * Displays a single Gallery model.
     * @param integer $id
     * @additionalParam string $format
     * @return mixed
     */
    public function actionView($id,$format= false)
    {
        $model = $this->findModel($id);
        
        if ($format == 'json')
        {
			return \yii\helpers\Json::encode($model);	
		}
		else
		{
			return $this->render('view', [
				'model' => $model,
			]);
		}        
    }

    /**
     * Creates a new Gallery model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gallery();
        $model->time = date("Y-m-d H:i:s");	
        $model->type = 0;
        $model->isdel = 0;
		
		$post = Yii::$app->request->post();
		if (isset($post['Gallery']['tags']))
		{
			if (is_array($post['Gallery']['tags']))
			{
				$post['Gallery']['tags'] = implode(",",$post['Gallery']['tags']);
			}	
		}
		
        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Gallery model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$model->tags = !empty($model->tags)?explode(",",$model->tags):[];
		
		$post = Yii::$app->request->post();
		if (isset($post['Gallery']['tags']))
		{
			if (is_array($post['Gallery']['tags']))
			{
				$post['Gallery']['tags'] = implode(",",$post['Gallery']['tags']);
			}	
		}
		
        if ($model->load($post) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Gallery model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {        
		$model = $this->findModel($id);        
        $model->isdel = 1;
        $model->save();
        //$model->delete(); //this will true delete
        
        return $this->redirect(['index']);
    }

    /**
     * Finds the Gallery model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gallery the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
