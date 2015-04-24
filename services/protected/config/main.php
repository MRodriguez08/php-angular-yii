<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '4Wheels',    
    'defaultController' => 'site/index',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        
        /* user bundle*/
        'application.models.user.*',
        
        /* audit bundle */
        'application.models.audit.*',
        
        
        /* system parameters bundle */
        'application.models.sysparam.*',
        
        /* system parameters bundle */
        'application.models.brand.*',
        
        /* components */
        'application.components.*',
        
        /* components */
        'ext.*',

    ),
    'aliases' => array(
        
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '4wheels',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
    'homeUrl' => array('site/index'),
    // application components
    'components' => array(
        'user' => array(
            'class' => 'WebUser',
            'loginUrl' => array('user/login'),
            'allowAutoLogin' => true,            
        ),
        // uncomment the following to enable URLs in path-format
        'defaultController' => 'site',
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                
                'brand/\w+' => 'brand/processRequest',
                'brand' => 'brand/processRequest',
                
                '<controller:\w+>/<id:\d+>' => '<controller>/view',                
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',                

            ),
        ),
        'db' => array(
            'connectionString' => 'pgsql:host=localhost;port=5432;dbname=angularyii-db',
            'emulatePrepare' => true,
            'username' => 'postgres',
            'password' => 'pg_admin',
            'charset' => 'utf8',
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error',
                    'categories'=>'system.*',
                ),
                array(
                    'class'=>'ext.DBLog',
                    //'autoCreateLogTable'=>false,
                    'logTableName' => 'error_log',
                    'connectionID'=>'db',
                    'categories'=>'application.*',
                    'enabled'=>true,
                    'levels'=>'trace',//You can replace trace,info,warning,error
                ),
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    "params" => include(dirname(__FILE__) . "/parameters.php" ),
);
