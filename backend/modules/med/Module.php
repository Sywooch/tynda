<?php

namespace app\modules\med;
use app\modules\rbac\components\AccessControl;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\med\controllers';

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
