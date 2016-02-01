<?php

namespace app\modules\goods;
use app\modules\rbac\components\AccessControl;
class module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\goods\controllers';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
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
