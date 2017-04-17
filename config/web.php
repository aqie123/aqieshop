<?php

$params = require(__DIR__ . '/params.php');
$adminmenu = require(__DIR__. '/adminmenu.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'index',
    'language'=>'zh-cn',
    'charset'=>'utf-8',
    'aliases'=> [
        '@aqie/mailerqueue' => '@vendor/aqie/mailerqueue/src'
    ],
    'components' => [
        // 配置日志
        /*
        'asyncLog' => [
            'class' => '\\app\\models\\Kafka',
            'broker_list' => '192.168.1.102:9092',
            'topic' => 'asynclog',
        ],*/
        // 配置session
        'session' => [
            // 把session 写到redis
            'class' => 'yii\redis\Session',
            'redis' => [
                'hostname' => 'localhost',
                'port' => 6379,
                // 存储到3号数据库
                'database' => '3'
            ],
            // 前缀
            'keyPrefix' => 'aqie_sess_',
        ],
        // 配置redis
        'redis' => [
            'class' => 'yii\redis\Connection',
            'hostname' => 'localhost',
            'port' => 6379,
            'database' => 0,
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
        // 权限管理
        'authManager' => [
            'class' => 'yii\rbac\DbManager', //数据存储 //文件存储phpManager
            // auth_item (role permission)    角色权限
            // auth_item_child (role->permission) 角色分配权限
            // auth_assignment (user->role) 用户分配角色
            // auth_rule (rule)     规则
            'itemTable' => '{{%auth_item}}',        // 数据表
            'itemChildTable' => '{{%auth_item_child}}',
            'assignmentTable' => '{{%auth_assignment}}',
            'ruleTable' => '{{%auth_rule}}',
            'defaultRoles' => ['default'],
        ],
        // 开发使用未压缩
        'assetManager' => [
            'class' => 'yii\web\AssetManager',
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'jquery.js' : 'jquery.min.js'
                    ],
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        YII_ENV_DEV ? 'css/bootstrap.css' : 'css/bootstrap.min.css',
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        YII_ENV_DEV ? 'js/bootstrap.js' : 'js/bootstrap.min.js',
                    ]
                ]
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'aqie',
        ],
        'cache' => [
            // 默认缓存到文件
            // 'class' => 'yii\caching\FileCache',
            'class' => 'yii\redis\Cache',
            'redis'=>[
                'hostname' =>'localhost',
                'port'=>6379,
                'database'=>2,          // 缓存存到2号redis库
            ]
        ],
        // 前台登录 用户认证体系
        'user' => [
            'identityClass' => 'app\models\User',       // 操作user表,默认类
            'enableAutoLogin' => true,                  // 允许自动登录
            'idParam' => '__user',                  //默认是__id
            'identityCookie' => ['name' => '__user_identity', 'httpOnly' => true],
            'loginUrl' => ['/member/auth'],

        ],
        // 自定义 后台登录
        'admin' => [
            'class' => 'yii\web\User',      // 还是user组件
            'identityClass' => 'app\modules\models\Admin',  // 然后去实现
            'idParam' => '__admin',
            'identityCookie' => ['name' => '__admin_identity', 'httpOnly' => true],
            'enableAutoLogin' => true,
            'loginUrl' => ['/admin/public/login'],

        ],
        'errorHandler' => [
            //'errorAction' => 'index/error',
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            // 'class' => 'yii\swiftmailer\Mailer',
            'class'=>'aqie\mailerqueue\MailerQueue',
            'db' => 1,          // 选择数据库1
            'key' => 'mails',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
              'class' => 'Swift_SmtpTransport',
              'host' => 'smtp.163.com',
              'username' => 'aqie123aqie@163.com',
              'password' => 'aqie123aqie',
              'port' => '465',
              'encryption' => 'ssl',
           ],
        ],
        'sentry' => [
            'class' => 'mito\sentry\Component',
            'dsn' => 'https://8d4380928d884740847741fd6b4e504a:6586bc0b3cf944f289e27c5a6dce87de@sentry.io/156581', // private DSN
            'publicDsn' =>'https://8d4380928d884740847741fd6b4e504a@sentry.io/156581',
            'environment' => 'staging', // if not set, the default is `production`
            'jsNotifier' => true, // to collect JS errors. Default value is `false`
            'jsOptions' => [ // raven-js config parameter
                'whitelistUrls' => [ // collect JS errors from these urls
                    //'http://staging.my-product.com',
                    //'https://my-product.com',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                // sentry 错误
                [
                    'class' => 'mito\sentry\Target',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@app/runtime/logs/shop/application.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'trace'],
                    'logFile' => '@app/runtime/logs/shop/info.log',
                    'categories' => ['myinfo'],      // Yii::info() 第二个参数
                    'logVars' => [],
                ],
                // 给开发者发邮件
                /*      正常会影响访问
                [
                 'class' => 'yii\log\EmailTarget',
                 'mailer' =>'mailer',
                 'levels' => ['error', 'warning'],
                 'message' => [
                     'from' => ['aqie123aqie@163.com'],
                     'to' => ['2924811900@qq.com'],
                     'subject' => 'aqie_shop的日志',
                 ],
                ],
                */
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),

        'urlManager' => [
            // 地址美化
            'enablePrettyUrl' => true,
            // 不显示脚本文件
            'showScriptName' => false,
            'rules' => [

                '<controller:(index|cart|order)>' => '<controller>/index',
                'auth' => 'member/auth',
                'product-category-<cateid:\d+>' => 'product/index',
                'product-<productid:\d+>' => 'product/detail',
                'order-check-<orderid:\d+>' => 'order/check',
                [
                    'pattern' => 'aqieback',        // http://www.yii2.com/aqieback
                    'route' => '/admin/default/index',
                    //'suffix' => '.html',
                ],

            ],
        ],

    ],
    'params' => array_merge($params,['adminmenu'=>$adminmenu]),
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => [$_SERVER["REMOTE_ADDR"]],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // 配置允许的ip访问列表
        'allowedIPs' => ['127.0.0.1'],
    ];
    // 添加新的模块
    $config['modules']['admin'] = [
        'class' => 'app\modules\admin',
    ];
}

return $config;
