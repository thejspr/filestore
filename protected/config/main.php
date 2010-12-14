<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'name'=>'FileStorage',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.ext.yii-mail.YiiMailMessage',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'dev123',
		),
	),
   'behaviors' => array(
        'onbeginRequest' => array(
                'class' => 'application.components.StartupBehavior',
        ),
    ),
	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'urlManager'=>array(
			'urlFormat'=>'get',
			'showScriptName'=>true,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
        'mail' => array(
            'class' => 'application.ext.yii-mail.YiiMail',
            'transportType' => 'php',
            'viewPath' => 'application.views.user',
            'logging' => true,
            'dryRun' => false
        ),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=fapp',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'dev123',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					//'levels'=>'info, error, warning',
					'levels'=>'error, warning',
					'logFile'=>'msgs.log',
				),
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
	'params'=>array(
	    'admin_email'=>'jkjeldgaard@gmail.com',
		'filesPath'=>'protected/data/f/',
        'maxFileSize'=> 1048576 * ini_get('upload_max_filesize'),
		'time_long'=>'d-m-Y h:i',
		'fb'=> 1,
		'fb_appid' => '123271937729319',
		'fb_api'=>'b180e217926135292c10800d9c27045f',
		'fb_sec'=>'404e64224550947da719f55f90070e50',
	),
);
