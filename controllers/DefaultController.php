<?php

namespace amilna\blog\controllers;

use Yii;
use yii\web\Controller;
use vova07\imperavi\actions\UploadAction;
use vova07\imperavi\actions\GetAction;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    
    public function actions()
	{
		$url = Yii::$app->urlManager->baseUrl.'/static';
		$path = '@webroot/static';				
		
		return [
			'image-upload' => [
				'class' => 'vova07\imperavi\actions\UploadAction',
				'url' => $url, // Directory URL address, where files are stored.
				'path' => $path // Or absolute path to directory where files are stored.
			],
			'images-get' => [
				'class' => 'vova07\imperavi\actions\GetAction',
				'url' => $url, // Directory URL address, where files are stored.
				'path' => $path, // Or absolute path to directory where files are stored.
				'type' => GetAction::TYPE_IMAGES,
			],
			'file-upload' => [
				'class' => 'vova07\imperavi\actions\UploadAction',
				'url' => $url, // Directory URL address, where files are stored.
				'path' => $path // Or absolute path to directory where files are stored.
			],
			'files-get' => [
				'class' => 'vova07\imperavi\actions\GetAction',
				'url' => $url, // Directory URL address, where files are stored.
				'path' => $path, // Or absolute path to directory where files are stored.
				'type' => GetAction::TYPE_FILES,
			],
			
		];
	}
}
