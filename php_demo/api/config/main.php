<?php

$params = array_merge(
    require(__DIR__ . '/params.php')
);
if (YII_ENV_TEST) {

	// 测试环境
	// YII_ENV_TEST => test

return [
    'id' => 'app-api',
    'timeZone' => 'Asia/Shanghai',
   // 'timeZone' =>'UTC',
    'basePath' => dirname(__DIR__),
  //  'bootstrap' => ['log'],
  
    'runtimePath' => '/opt/app/runtime', // 临时产生文件的目录runtime
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],
        'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\Module',
        ],
    ],
    'components' => [

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                ],
                'YQLogger'=>[
                    'class' => 'api\components\YQLogger',
                    'categories'=> ['info'],
                    'logVars' => [],
                ],
                'YQErrorLogger'=>[
                    'class' => 'api\components\YQErrorLogger',
                    'categories'=> ['error'],
                    'logVars' => [],
                ]
            ],
        ],
        'urlManager' => [
            //'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            //'rules' => [
            //    [
            //        //'class' => 'yii\rest\UrlRule',
            //        //'controller' => 'v1/user',
			//		//'controller' => 'v1/event',
			//		 '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
            //    ],
            //],
        ],
        'request' =>[
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            ////'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            //'on beforeSend' => function ($event) {
            //    $response = $event->sender;
            //    if ($response->data !== null) {
            //        $response->data = [
            //            'success' => $response->isSuccessful,
            //            'data' => $response->data,
            //        ];
            //        $response->statusCode = 200;
            //    }
            //},
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

		'cache' => [
		   'class' => 'yii\redis\Cache',
		   //'servers' => [
		   //    [
		   //        'host' => 'localhost',
		   //        'port' => 11211,
		   //        'weight' => 100,
		   //    ],
		   //],
		],
		
		'redis' => [
			'class' => 'yii\redis\Connection',
			'hostname' => 'test.redis.cache.chinacloudapi.cn',
			'port' => 6379,
			'database' => 0,
			'password' => 'test123',
		],
    ],
    'params' => $params,
];

}else if(YII_ENV_DEV){

	// 预上线环境
	// YII_ENV_DEV => dev
return [
    'id' => 'app-api',
    'timeZone' => 'Asia/Shanghai',
   // 'timeZone' =>'UTC',
    'basePath' => dirname(__DIR__),
  //  'bootstrap' => ['log'],
  
    'runtimePath' => '/opt/app/runtime', // 临时产生文件的目录runtime
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],
        'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\Module',
        ],
    ],
    'components' => [

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                ],
                'YQLogger'=>[
                    'class' => 'api\components\YQLogger',
                    'categories'=> ['info'],
                    'logVars' => [],
                ],
                'YQErrorLogger'=>[
                    'class' => 'api\components\YQErrorLogger',
                    'categories'=> ['error'],
                    'logVars' => [],
                ]
            ],
        ],
        'urlManager' => [
            //'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            //'rules' => [
            //    [
            //        //'class' => 'yii\rest\UrlRule',
            //        //'controller' => 'v1/user',
			//		//'controller' => 'v1/event',
			//		 '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
            //    ],
            //],
        ],
        'request' =>[
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            ////'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            //'on beforeSend' => function ($event) {
            //    $response = $event->sender;
            //    if ($response->data !== null) {
            //        $response->data = [
            //            'success' => $response->isSuccessful,
            //            'data' => $response->data,
            //        ];
            //        $response->statusCode = 200;
            //    }
            //},
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

		'cache' => [
		   'class' => 'yii\redis\Cache',
		   //'servers' => [
		   //    [
		   //        'host' => 'localhost',
		   //        'port' => 11211,
		   //        'weight' => 100,
		   //    ],
		   //],
		],
		
		'redis' => [
			'class' => 'yii\redis\Connection',
			'hostname' => 'test.redis.cache.chinacloudapi.cn',
			'port' => 6379,
			'database' => 0,
			'password' => 'test123',
		],
    ],
    'params' => $params,
];

}elseif(YII_ENV_PROD){
	
	// 线上环境
	// YII_ENV_PROD => prod
	
return [
    'id' => 'app-api',
    'timeZone' => 'Asia/Shanghai',
   // 'timeZone' =>'UTC',
    'basePath' => dirname(__DIR__),
  //  'bootstrap' => ['log'],
  
    'runtimePath' => '/opt/app/runtime', // 临时产生文件的目录runtime
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],
        'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\Module',
        ],
    ],
    'components' => [

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'error', 'warning'],
                ],
                'YQLogger'=>[
                    'class' => 'api\components\YQLogger',
                    'categories'=> ['info'],
                    'logVars' => [],
                ],
                'YQErrorLogger'=>[
                    'class' => 'api\components\YQErrorLogger',
                    'categories'=> ['error'],
                    'logVars' => [],
                ]
            ],
        ],
        'urlManager' => [
            //'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            //'rules' => [
            //    [
            //        //'class' => 'yii\rest\UrlRule',
            //        //'controller' => 'v1/user',
			//		//'controller' => 'v1/event',
			//		 '<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
            //    ],
            //],
        ],
        'request' =>[
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            ////'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            //'on beforeSend' => function ($event) {
            //    $response = $event->sender;
            //    if ($response->data !== null) {
            //        $response->data = [
            //            'success' => $response->isSuccessful,
            //            'data' => $response->data,
            //        ];
            //        $response->statusCode = 200;
            //    }
            //},
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

		'cache' => [
		   'class' => 'yii\redis\Cache',
		   //'servers' => [
		   //    [
		   //        'host' => 'localhost',
		   //        'port' => 11211,
		   //        'weight' => 100,
		   //    ],
		   //],
		],
		
		'redis' => [
			'class' => 'yii\redis\Connection',
			'hostname' => 'test.redis.cache.chinacloudapi.cn',
			'port' => 6379,
			'database' => 0,
			'password' => 'test123',
		],
    ],
    'params' => $params,
];

}
