<?php

namespace app\modules\page;
use Yii;
use app\modules\rbac\components\AccessControl;

class Module extends \yii\base\Module
{
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
    }
}
