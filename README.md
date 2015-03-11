Blog for Yii
============
Blogging module support for Yii2 (includes banner and gallery, support mysql and postgresql)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Since this package do not have stable release on packagist, you should use these settings in your composer.json file :

```json
"minimum-stability": "dev",
"prefer-stable": true,
"repositories":[
		
		{
			"type": "vcs",
			"url": "https://github.com/aaiyo/yii2-kcfinder"
		}	
   ]
```
After, either run

```
php composer.phar require --prefer-dist amilna/yii2-blog "dev-master"
```

or add

```
"amilna/yii2-blog": "dev-master"
```

to the require section of your `composer.json` file.

run migration for database

```
./yii migrate --migrationPath=@amilna/blog/migrations
```

add in modules section of main config

```
	'gridview' =>  [
		'class' => 'kartik\grid\Module',
	],
	'blog' => [
		'class' => 'amilna\blog\Module',
		/* 'userClass' => 'dektrium\user\models\User', // example if use another user class */
	],
```

Usage
-----

Once the extension is installed, check the url:
[your application base url]/index.php/blog


