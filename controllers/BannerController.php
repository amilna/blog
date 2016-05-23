<?php

namespace amilna\blog\controllers;

use Yii;
use amilna\blog\models\Banner;
use amilna\blog\models\BannerSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BannerController implements the CRUD actions for Banner model.
 */
class BannerController extends Controller
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
     * Lists all Banner models.
     * @params string $format, array $arraymap, string $term
     * @return mixed
     */
    public function actionIndex($format= false,$arraymap= false,$term = false)
    {      		
        
        $searchModel = new BannerSearch();        
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
			$bannerProvider = new ActiveDataProvider([
				'models' => Banner::find()->where('status = true AND isdel = 0 order by position asc')->all(),
				'pagination'=>false,
				/*'pagination' => [
					'pageSize' => 20,
				],*/
			]);    
			
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'bannerProvider' => $bannerProvider,
			]);
		}	
    }

    /**
     * Displays a single Banner model.
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
     * Creates a new Banner model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Banner();
        $model->time = date("Y-m-d H:i:s");
        $model->position = $model->getLast();
        $model->isdel = 0;
		
		$post = Yii::$app->request->post();
		if (isset($post['Banner']['tags']))
		{
			if (is_array($post['Banner']['tags']))
			{
				$post['Banner']['tags'] = implode(",",$post['Banner']['tags']);
			}	
		}
		
		$transaction = Yii::$app->db->beginTransaction();
		try {				
			if ($model->load($post) && $model->save()) {
				$model->updatePosition($model->position);
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
		
		return $this->render('create', [
			'model' => $model,
		]);
	
    }

    /**
     * Updates an existing Banner model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
		$model->tags = !empty($model->tags)?explode(",",$model->tags):[];
		
		$post = Yii::$app->request->post();
		if (isset($post['Banner']['tags']))
		{
			if (is_array($post['Banner']['tags']))
			{
				$post['Banner']['tags'] = implode(",",$post['Banner']['tags']);
			}	
		}
		
		$transaction = Yii::$app->db->beginTransaction();
		try {				
			if ($model->load($post) && $model->save()) {
				$model->updatePosition($model->position);
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
		        
		return $this->render('update', [
			'model' => $model,
		]);
	
    }

    /**
     * Deletes an existing Banner model.
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
     * Finds the Banner model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Banner the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Banner::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
