<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'test123',
        ],
    ],
];
if (!YII_ENV_PROD) {
        //zhengshanxi 2016/12/12 set test and dev environment can use gii
        // configuration adjustments for 'dev' environment
        $config['bootstrap'][] = 'debug';
        $config['modules']['debug'] = 'yii\debug\Module';

        $config['bootstrap'][] = 'gii';
		$config['modules']['gii'] = [
			'class' => 'yii\gii\Module',
			'allowedIPs' => ['127.0.0.1'],
		];
}

return $config;
