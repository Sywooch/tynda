<?php

namespace app\modules\service;

use app\modules\rbac\components\AccessControl;

class module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\service\controllers';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                        'denyCallback' => function ($rule, $action){
                            return $this->redirect(['login']);
                        }
                    ],
                ],
            ],
        ];
    }

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
