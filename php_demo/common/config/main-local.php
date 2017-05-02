<?php

if (YII_ENV_TEST) {

    // 测试环境用
    return [
        'components' => [

            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=test.mysqldb.chinacloudapi.cn;dbname=test',
                'username' => 'test',
                'password' => 'test123',
                //                'charset' => 'utf8mb4',
                /* 'slaves' => [
                     ['dsn' => 'mysql:host=test.mysqldb.chinacloudapi.cn;dbname=test',
                      'username' => 'test',
                     'password' => 'test123',],
                 ]*/
            ],

            'db_slave' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=test.mysqldb.chinacloudapi.cn;dbname=test',
                'username' => 'test',
                'password' => 'test123',
            ],
            'db_rescms' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=test1.mysqldb.chinacloudapi.cn;dbname=test1',
                'username' => 'test1',
                'password' => 'test123',
                'charset' => 'utf8',
            ],

            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@common/mail',
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
                'useFileTransport' => true,
            ],
        ],
    ];

} else if(YII_ENV_DEV){

	// 预上线用
    return [
        'components' => [

            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=test.mysqldb.chinacloudapi.cn;dbname=test',
                'username' => 'test',
                'password' => 'test123',
                //                'charset' => 'utf8mb4',
                /* 'slaves' => [
                     ['dsn' => 'mysql:host=test.mysqldb.chinacloudapi.cn;dbname=test',
                      'username' => 'test',
                     'password' => 'test123',],
                 ]*/
            ],

            'db_slave' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=test.mysqldb.chinacloudapi.cn;dbname=test',
                'username' => 'test',
                'password' => 'test123',
            ],
            'db_rescms' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=test1.mysqldb.chinacloudapi.cn;dbname=test1',
                'username' => 'test1',
                'password' => 'test123',
                'charset' => 'utf8',
            ],

            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@common/mail',
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
                'useFileTransport' => true,
            ],
        ],
    ];

}else if(YII_ENV_PROD){

    // 线上环境用
    return [
        'components' => [

            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=test.mysqldb.chinacloudapi.cn;dbname=test',
                'username' => 'test',
                'password' => 'test123',
                //                'charset' => 'utf8mb4',
                /* 'slaves' => [
                     ['dsn' => 'mysql:host=test.mysqldb.chinacloudapi.cn;dbname=test',
                      'username' => 'test',
                     'password' => 'test123',],
                 ]*/
            ],

            'db_slave' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=test.mysqldb.chinacloudapi.cn;dbname=test',
                'username' => 'test',
                'password' => 'test123',
            ],
            'db_rescms' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=test1.mysqldb.chinacloudapi.cn;dbname=test1',
                'username' => 'test1',
                'password' => 'test123',
                'charset' => 'utf8',
            ],

            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@common/mail',
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
                'useFileTransport' => true,
            ],
        ],
    ];
}

