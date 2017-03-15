<?php
use yii\helpers\Html;

$params = require(__DIR__ . '/params.php');




$config = [
	//'homeurl'=>'/basic/web/category',
	'sourceLanguage'=>'ru_ru',
	'charset' => 'utf-8',
	'language' => 'ru-RU',
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
	
		'urlManager' => [
		
		  //'BaseUrl' => '/basic/web',

          'showScriptName' => false,

          'enablePrettyUrl' => true,
		  
		  'rules' => [
		   'test' => 'test/index',
		  'category/admin' => 'category/admin',
		  'category/admin/categories' => 'category/categories',
		  'category/admin/subcategories' => 'category/subcategories',
		  'category/admin/products' => 'category/products',
		  
		  'category/<level1:>' => 'category/index',
		  'category/<level1:>/<level2:>' => 'category/index',
		  'category/<level1:>/<level2:>/<level3:>' => 'category/index',
		 
            ],

        ],

	
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '6z5oKVG_ci1DtSHL6PTWdgBv7n4Id8Tz',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
];

/*

function test(&$arr,$i,$lvl,&$path){
	
	if($i<$lvl){
		$i++;
		$path.= Html::encode("<name".$i.":>");
		$arr[] = $path;
		test($arr,$i,$lvl,$path);
	}
	
}


$path = Html::encode("<name1:>");

$arr[] = $path; 

test($arr,1,3,$path);

foreach($arr as $val){
$config["components"]["urlManager"]["rules"]['category/'.$val.''] = 'category/index';
}

*/



if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}






return $config;
