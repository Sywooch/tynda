<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],

    /*'on beforeRequest' => function ($event) {
        if(!Yii::$app->request->isSecureConnection){
            // add some filter/exemptions if needed ..
            $url = Yii::$app->request->getAbsoluteUrl();
            $url = str_replace('http:', 'https://', $url);
            Yii::$app->getResponse()->redirect($url);
            Yii::$app->end();
        }
    },*/

    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'cache' => require(__DIR__.'/_cache.php'),
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
