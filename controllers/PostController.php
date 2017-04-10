<?php

namespace amilna\blog\controllers;

use Yii;
use amilna\blog\models\Post;
use amilna\blog\models\PostSearch;
use amilna\blog\models\BlogCatPos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends Controller
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
     * Lists all Post models.
     * @params string $format, array $arraymap, string $term
     * @return mixed
     */
    public function actionIndex($format= false,$arraymap= false,$term = false,$category = false,$time = false)
    {                
        $searchModel = new PostSearch();        
        $req = Yii::$app->request->queryParams;
        if ($term) { $req[basename(str_replace("\\","/",get_class($searchModel)))]["term"] = $term;}        
        if ($category) { $req[basename(str_replace("\\","/",get_class($searchModel)))]["category"] = $category;}        
        if ($time) { $req[basename(str_replace("\\","/",get_class($searchModel)))]["time"] = $time;}
        $dataProvider = $searchModel->search($req);				
		        
        $query = $dataProvider->query;
        $query->andWhere(['status'=>[1]]);	
        
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
			header("Access-Control-Allow-Origin: *");
			header("Access-Control-Expose-Headers: X-Pagination-Per-Page,X-Pagination-Current-Page,X-Pagination-Page-Count,X-Pagination-Total-Count,Content-Type,Location");
			return \yii\helpers\Json::encode($model);	
		}
		else
		{
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}	
    }

    public function actionAdmin($format= false,$arraymap= false,$term = false)
    {                
        $searchModel = new PostSearch();        
        $req = Yii::$app->request->queryParams;
        if ($term) { $req[basename(str_replace("\\","/",get_class($searchModel)))]["term"] = $term;}        
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
			return $this->render('admin', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		}	
    }

    /**
     * Displays a single Post model.
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
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Post();
        $model->time = date("Y-m-d H:i:s");	
        $model->author_id = Yii::$app->user->id;
        $model->isdel = 0;

        if (Yii::$app->request->post())        
        {
			$post = Yii::$app->request->post();									
			$category = [];						
			if (isset($post['Post']['category']))
			{
				$category = $post['Post']['category'];
			}		
			
			if (is_array($post['Post']['tags']))
			{
				$post['Post']['tags'] = implode(",",$post['Post']['tags']);
			}		
				
			$model->load($post);
			
			$transaction = Yii::$app->db->beginTransaction();
			try {				
				
				if ($model->save()) {
					
					$cs = BlogCatPos::deleteAll("post_id = :id",["id"=>$model->id]);
					
					foreach ($category as $d)
					{
						$c = new BlogCatPos();						
						$c->post_id = $model->id;
						$c->category_id = $d;
						$c->isdel = 0;					
						$c->save();								
					}
									
					$transaction->commit();                                    				
					return $this->redirect(['view', 'id' => $model->id]);            
				}				
				else
				{
					$model->id = array_merge($category,[]);	
					$transaction->rollBack();					
				}				
			} catch (Exception $e) {
				$transaction->rollBack();				
			}   						
		}	
        
        return $this->render('create', [
			'model' => $model,
		]);
    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);		
		$model->tags = !empty($model->tags)?explode(",",$model->tags):[];				
		
		if (Yii::$app->request->post())        
        {
			$post = Yii::$app->request->post();						
			$category = [];						
			if (isset($post['Post']['category']))
			{
				$category = $post['Post']['category'];
			}			
			
			if (is_array($post['Post']['tags']))
			{
				$post['Post']['tags'] = implode(",",$post['Post']['tags']);
			}		
        
			$model->load($post);
			
			$transaction = Yii::$app->db->beginTransaction();
			try {				
						
				if ($model->save()) {
					
					$cs = BlogCatPos::deleteAll("post_id = :id",["id"=>$model->id]);							
					
					foreach ($category as $d)
					{					
						//$c = BlogCatPos::find()->where("post_id = :id AND category_id = :aid",["id"=>$model->id,"aid"=>intval($d)])->one();					
						//if (!$c)
						//{
							$c = new BlogCatPos();	
						//}					
						$c->post_id = $model->id;
						$c->category_id = $d;
						$c->isdel = 0;					
						$c->save();								
					}
					
					$transaction->commit();                                    				
					return $this->redirect(['view', 'id' => $model->id]);            
				}
				else
				{
					$transaction->rollBack();
				}				
			} catch (Exception $e) {
				$transaction->rollBack();
			}   
		}	
        
        return $this->render('update', [
			'model' => $model,
		]);
    }

    /**
     * Deletes an existing Post model.
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
        
        return $this->redirect(['admin']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
