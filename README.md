Blog for Yii
============
Blogging module support for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist amilna/yii2-blog "dev-master"
```

or add

```
"amilna/yii2-blog": "dev-master"
```

to the require section of your `composer.json` file.

Since this extensions stil in dev stages, be sure also add following line in `composer.json` file.

```json
"repositories":[
		{
			"type": "git",
			"url": "https://github.com/amilna/blog"
		},
		{
			"type": "git",
			"url": "https://github.com/amilna/yap"
		},
		{
			"type": "git",
			"url": "https://github.com/amilna/yii2-sequence-widget"
		}	
   ]
```

run migration for database

```
./yii migrate --migrationPath=@amilna/blog/migrations
```

add in modules section of main config

```
	'gridview' =>  [
		'class' => 'kartik\grid\Module',
	],
	'cap' => [
		'class' => 'amilna\blog\Module',
	],
```

Usage
-----

Once the extension is installed, check the url:
[your application base url]/index.php/blog


