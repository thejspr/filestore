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
			'password'=>'',
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
		'file'=>array(
            'class'=>'application.ext.cfile.CFile',
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
			'username' => '',
			'password' => '',
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
	    'admin_email'=>',
		'filesPath'=>'protected/data/f/',
        'maxFileSize'=> 1048576 * ini_get('upload_max_filesize'),
		'time_long'=>'d-m-Y h:i',
		'fb'=> 1,
		'fb_appid' => '',
		'fb_api'=>'',
		'fb_sec'=>'',
	),
);
