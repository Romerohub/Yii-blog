<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'NetKurator',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
			'application.helpers.*',
	),
    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'123',
        ),
    ),
	'defaultController'=>'post',
	'theme'=>'modern',
	'sourceLanguage'=>'en_US',
	'language' => 'ru_RU',
	'charset'=>'utf-8',

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),/*
		'db'=>array(
			'connectionString' => 'sqlite:protected/data/blog.db',
			'tablePrefix' => 'tbl_',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=yii-blog',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'tbl_',
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
        'urlManager'=>array(
        	'urlFormat'=>'path',
        	'showScriptName'=>false,
        	'urlSuffix'=>".html",
        	'rules'=>array(
        	
        	/*Закомитить gii когда будет не нужно*/
        	'gii'=>'gii',
            'gii/<controller:\w+>'=>'gii/<controller>',
            'gii/<controller:\w+>/<action:\w+>'=>'gii/<controller>/<action>',
        	
        	'comment'=>'comment',
        	'comment/<controller:\w+>'=>'comment/<controller>',
            'comment/<controller:\w+>/<action:\w+>'=>'comment/<controller>/<action>',
            
        	'user'=>'user',
            'user/<controller:\w+>'=>'user/<controller>',
            'user/<controller:\w+>/<action:\w+>'=>'user/<controller>/<action>',
            
			'page'=>'page',
			'page/<url:[0-9a-zA-Z\-\_]+>'=>'page/view',
            'pages/<controller:\w+>'=>'page/<controller>',
            'pages/<controller:\w+>/<action:\w+>'=>'page/<controller>/<action>',
        	
        	//'page/<url:[0-9a-zA-Z\-\_]+>'=>'post/view', //Это если id строка*/
        	'<url:[0-9a-zA-Z\-\_]+>'=>'post/view',
        		/*'post/<id:\d+>/<title:.*?>'=>'post/view',*/
        	'cat/<cat:.*?>'=>'post/index',
        	'posts/<tag:.*?>'=>'post/index',
        	'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        		
        	),
        ),
'image'=>array(
          'class'=>'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver'=>'GD',
            // ImageMagick setup path
            'params'=>array('directory'=>'/opt/local/bin'),
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
);