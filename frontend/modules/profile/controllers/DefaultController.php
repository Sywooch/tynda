<?php

namespace app\modules\profile\controllers;

use common\models\users\Company;
use Yii;
use common\models\users\User;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;
use yii\filters\AccessControl;

/**
 * DefaultController implements the CRUD actions for User model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['company','change-login','change-avatar','change-email','change-fio','change-tel','change-password'],
                'rules' => [
                    [
                        'actions' => ['company','change-login','change-avatar','change-email','change-fio','change-tel','change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Displays a single User model.
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'model' => $user = self::findUser(),
        ]);
    }

    public function actionCompany(){
        $user = Yii::$app->user->getIdentity();
        if(User::isCompany()){
            $model = Company::findOne($user->id);
            $post = \Yii::$app->request->post();
            if($model->load($post)&&$model->save()){
                \Yii::$app->session->setFlash('success', 'Данные успешно сохранены.');
            }
            return $this->render('company',[
                'model' => $model,
            ]);
        }else{
            Yii::$app->session->setFlash('danger', '<strong>Вы зарегистрированы как частное лицо, и не можете заходить на эту страницу.</strong>');
            return $this->redirect(Url::home());
        }
    }

    public function actionChangeLogin(){
        $user = self::findUser();
        $pst = \Yii::$app->request->post();
        $post = $pst['User'];
        if($user->load($pst)){
            $user->username = $post['username'];
            try{
                if($user->save()){
                    Yii::$app->session->setFlash('success', 'Новый логин успешно установлен.');
                }else{
                    Yii::$app->session->setFlash('danger', 'Логин не изменен. <strong>Такой логин уже существует.</strong>');
                }
            }catch (\yii\db\IntegrityException $e){
                Yii::$app->session->setFlash('danger', 'Логин не изменен. <strong>Такой логин уже существует.</strong>');
            }
            return $this->redirect('index');
        }else{
            return $this->renderAjax('change-login', [
                'user' => $user,
            ]);
        }
    }

    public function actionChangeAvatar(){
        $model = self::findUser();
        $post = \Yii::$app->request->post();
        if($model->load($post)){
                $_image = \yii\web\UploadedFile::getInstance($model, 'image');
            if ($model->validate()) {

                // open image
                $image = Image::getImagine()->open($_image->tempName);

                $variants = [
                    [
                        'width' => 250,
                        'height' => 250,
                    ],
                ];

                // rendering information about crop of ONE option
                $cropInfo = Json::decode($post['User']['crop_info'])[0];
                $cropInfo['dWidth'] = (int)$cropInfo['dWidth']; //new width image
                $cropInfo['dHeight'] = (int)$cropInfo['dHeight']; //new height image
                $cropInfo['x'] = $cropInfo['x']; //begin position of frame crop by X
                $cropInfo['y'] = $cropInfo['y']; //begin position of frame crop by Y

                //delete old images
                $oldImages = FileHelper::findFiles(Yii::getAlias('@frt_dir/img/avatars/'), [
                    'only' => [
                        $model->id . '.*',
                        'thumb_' . $model->id . '.*',
                    ],
                ]);
                for ($i = 0; $i != count($oldImages); $i++) {
                    @unlink($oldImages[$i]);
                }
                //avatar image name
                $imgName = $model->id . '.' . $_image->getExtension();

                //saving thumbnail
                $newSizeThumb = new Box($cropInfo['dWidth'], $cropInfo['dHeight']);
                $cropSizeThumb = new Box(250, 250); //frame size of crop
                $cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
                $pathThumbImage = Yii::getAlias('@frt_dir/img/avatars/') . $imgName;

                $image->resize($newSizeThumb)
                    ->crop($cropPointThumb, $cropSizeThumb)
                    ->save($pathThumbImage, ['quality' => 100]);

                //save in database
                $model = User::findOne($model->id);
                $model->avatar = $imgName;
            }
                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Новый аватар успешно установлен.');
                }else{
                    Yii::$app->session->setFlash('danger', 'Аватар не изменен.');
                }
            return $this->redirect('index');
        }else{
            return $this->render('change-avatar', [
                'model' => $model,
            ]);
        }
    }

    public function actionChangeEmail(){
        $user = self::findUser();
        $pst = \Yii::$app->request->post();
        $post = $pst['User'];
        if($user->load($pst)){
            $user->email = $post['email'];
            try{
                if($user->save()){
                    Yii::$app->session->setFlash('success', 'Новый email успешно установлен.');
                }else{
                    Yii::$app->session->setFlash('danger', 'Email не изменен. <strong>Такой Email уже существует.</strong>');
                }
            }catch (\yii\db\IntegrityException $e){
                Yii::$app->session->setFlash('danger', 'Email не изменен. <strong>Такой Email уже существует.</strong>');
            }
            return $this->redirect('index');
        }else{
            return $this->renderAjax('change-email', [
                'user' => $user,
            ]);
        }
    }
    public function actionChangeFio(){
        $user = self::findUser();
        $pst = \Yii::$app->request->post();
        $post = $pst['User'];
        if($user->load($pst)){
            $user->name = $post['name'];
            $user->surname = $post['surname'];
            $user->patronym = $post['patronym'];
            try{
                if($user->save()){
                    Yii::$app->session->setFlash('success', 'Фамилия Имя Отчество успешно установлены.');
                }else{
                    Yii::$app->session->setFlash('danger', ' <strong>ФИО не изменены.</strong>');
                }
            }catch (\yii\db\IntegrityException $e){
                Yii::$app->session->setFlash('danger', ' <strong>ФИО не изменены.</strong>');
            }
            return $this->redirect('index');
        }else{
            return $this->renderAjax('change-fio', [
                'user' => $user,
            ]);
        }
    }

    public function actionChangeTel(){
        $user = self::findUser();
        $pst = \Yii::$app->request->post();
        $post = $pst['User'];
        if($user->load($pst)){
            $user->tel = $post['tel'];
            try{
                if($user->save()){
                    Yii::$app->session->setFlash('success', 'Новый телефон успешно установлен.');
                }else{
                    Yii::$app->session->setFlash('danger', 'Телефон не изменен. <strong>Такой телефон уже существует.</strong>');
                }
            }catch (\yii\db\IntegrityException $e){
                Yii::$app->session->setFlash('danger', 'Телефон не изменен. <strong>Такой телефон уже существует.</strong>');
            }
            return $this->redirect('index');
        }else{
            return $this->renderAjax('change-tel', [
                'user' => $user,
            ]);
        }
    }

    public function actionChangePassword()
    {
        $user = self::findUser();
        $pst = \Yii::$app->request->post();
        $post = $pst['User'];
        if ($user->load($pst)) {
            //print_r($post);
            if (!$user->validatePassword($post['old_password'])) {
                Yii::$app->session->setFlash('danger', 'Вы ввели неверный старый пароль.');
                return $this->redirect('index');
            } else {

                if ($user->setNewPassword($post['password']) && $user->save()) {
                    Yii::$app->session->setFlash('success', 'Новый пароль успешно установлен.');
                    return $this->redirect('index');
                } else {
                    Yii::$app->session->setFlash('danger', 'Новый пароль не установлен.');
                }
                return $this->redirect('index');
            }
        } else {
            return $this->renderAjax('change-password', [
                'user' => $user,
            ]);
        }
    }

    private static function findUser(){
        return \common\models\users\User::findOne(Yii::$app->user->identity->getId());
    }
}
