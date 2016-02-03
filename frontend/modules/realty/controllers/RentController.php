<?php

namespace app\modules\realty\controllers;

use Yii;

use common\models\realty\RealtyCat;
use common\models\realty\RealtyRent;
use common\models\realty\RealtyRentSearch;
use common\models\realty\RealtyRentImg;
use common\models\realty\VRealtyRent;
use common\models\users\User;
use common\models\users\UserAccount;
use yii\web\Controller;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\widgets\Arrays;
use yii\filters\AccessControl;
use yii\data\Pagination;

/**
 * RealtyController implements the CRUD actions for Realty model.
 */
class RentController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['change-status','change-up','change-vip','my-ads','create','update','delete','delete-images','delete-image'],
                'rules' => [
                    [
                        'actions' => ['change-status','change-up','change-vip','my-ads','create','update','delete','delete-images','delete-image'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Lists all Service models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RealtyRentSearch();
        $search = $searchModel->search(Yii::$app->request->queryParams);
        $this->delSession();
        if($search){
            $dataProvider = $search;
            return $this->render('index', [
                'items' => true,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }else{
            return $this->render('index', [
                'items' => false,
            ]);
        }
    }

    private function delSession(){
        $get = \Yii::$app->request->get();
        if((!$get['cat']&&!$get['RealtyRentSearch']['cat'])){
            $ses = Yii::$app->session;
            $ses->open();
            $ses->set('current_cat',null);
            $ses->set('parent_cat',null);
            $ses->set('cat_child',null);
            $ses->set('first_child',null);
            $ses->close();
        }
    }

    /**
     * Displays a single VService model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = VRealtyRent::find()->where(['id'=>$id])->asArray()->one();
        RealtyCat::setSessionCategoryTree($model['alias']);
        $images = RealtyRentImg::find()->where(['id_ads'=>$model['id']])->asArray()->all();
        return $this->render('view', [
            'model' => $model,
            'images' => $images,
        ]);
    }

    /**
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new RealtyRent(['scenario'=>'create']);
        if ($model->load(Yii::$app->request->post())) {
            $model->id_user = Yii::$app->user->identity->getId();
            $model->status = 1;
            $model->images = \yii\web\UploadedFile::getInstances($model, 'images');
            if($model->validate()){
                if ($model->save(false)&&$model->upload()) {
                    \Yii::$app->session->setFlash('success', 'Объявление успешно создано.');
                    return $this->redirect(['update', 'id' => $model->id]);
                    //return $this->redirect(['my-ads', 'id' => $model->id]);
                }else{
                    \Yii::$app->session->setFlash('danger', 'По каким-то причинам объявление создать не удалось.<br>Пожалуйста повторите попытку.');

                }
            }
            return $this->render('create', ['model' => $model,]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $user = Yii::$app->user->getIdentity();
        $model = RealtyRent::find()->where(['id'=>$id,'id_user'=>$user->getId()])->one();
        if ($model->load(Yii::$app->request->post())) {
            $model->images = \yii\web\UploadedFile::getInstances($model, 'images');
            if($model->validate()) {
                if ($model->save()&&$model->upload()) {
                    \Yii::$app->session->setFlash('success', 'Изменения успешно внесены.');
                    //return $this->redirect(['my-ads', 'id' => $model->id]);
                }else{
                    \Yii::$app->session->setFlash('danger', 'По каким-то причинам сохранить изменения не удалось.<br>Пожалуйста повторите попытку.');
                }
            }
            return $this->render('update', [ 'model' => $model,]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $user_id = Yii::$app->user->identity->getId();
        $model = RealtyRent::findOne(['id'=>$id, 'id_user'=>$user_id]);
        if(RealtyRent::deleteImages($id,$user_id)){
            if($model->delete()){
                return $this->redirect(['my-ads']);
            }else{
                \Yii::$app->session->setFlash('danger', 'Объявление не было удалено.');
            }
        }else{
            \Yii::$app->session->setFlash('danger', 'По каким-то причинам объявление не было удалено.<br>Пожалуйста повторите попытку.');
            return $this->redirect(['update', 'id'=>$id]);
        }
    }

    public function actionDeleteImages($id){
        $user_id = Yii::$app->user->identity->getId();
        if(RealtyRent::deleteImages($id,$user_id)){
            return $this->redirect(['update', 'id'=>$id]);
        }else{
            \Yii::$app->session->setFlash('danger', 'По каким-то причинам картинки не были удалены.<br>Пожалуйста повторите попытку.');
            return $this->redirect(['update', 'id'=>$id]);
        }
    }

    public function actionDeleteImage($id, $id_ads){
        $user_id = Yii::$app->user->identity->getId();
        if(RealtyRent::deleteImage($id,$id_ads,$user_id)){
            return $this->redirect(['update', 'id'=>$id_ads]);
        }else{
            \Yii::$app->session->setFlash('danger', 'По каким-то причинам картинка не была удалена.<br>Пожалуйста повторите попытку.');
            return $this->redirect(['update', 'id'=>$id_ads]);
        }
    }

    /**
     * Lists all Service models.
     * @return mixed
     */
    public function actionMyAds()
    {
        $user = Yii::$app->user->getIdentity();
        $query = RealtyRent::find()->where(['id_user'=>$user->getId()]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $model = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('my-ads', [
            'user' => $user,
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    /**
     * Проверка какие инпуты показывать в форме в зависимости от выбраной категории.
     * @return mixed
     */
    public function actionChangeElement()
    {
        $post = (integer)\Yii::$app->request->post('cat_id');
        if($post){
            $model = RealtyCat::findOne(['id'=>$post]);
            $arr = [];
            if($model->readonly == 1){
                $arr['readonly'] = 'true';
            }else{
                $arr['readonly'] = 'false';
            }
            if($model->area_home == 1){
                $arr['area_home'] = 'show';
            }else{
                $arr['area_home'] = 'hide';
            }
            if($model->area_land == 1){
                $arr['area_land'] = 'show';
            }else{
                $arr['area_land'] = 'hide';
            }
            if($model->floor == 1){
                $arr['floor'] = 'show';
            }else{
                $arr['floor'] = 'hide';
            }
            if($model->floor_home == 1){
                $arr['floor_home'] = 'show';
            }else{
                $arr['floor_home'] = 'hide';
            }
            if($model->comfort == 1){
                $arr['comfort'] = 'show';
            }else{
                $arr['comfort'] = 'hide';
            }
            if($model->repair == 1){
                $arr['repair'] = 'show';
            }else{
                $arr['repair'] = 'hide';
            }
            if($model->resell == 1){
                $arr['resell'] = 'show';
            }else{
                $arr['resell'] = 'hide';
            }
            if($model->type == 1){
                $arr['type'] = 'show';
            }else{
                $arr['type'] = 'hide';
            }
            echo json_encode($arr);
        }
    }

    /**
     * Change status Service ads models.
     * @return mixed
     */
    public function actionChangeStatus()
    {
        $post = \Yii::$app->request->post('ads_id');
        if($post){
            $user = Yii::$app->user->getIdentity();
            $model = RealtyRent::findOne(['id'=>$post, 'id_user'=>$user->getId()]);
            if($model->status == 1){
                $model->status = 0;
            }else{
                $model->status = 1;
            }
            if ($model->save()) {
                echo $model->status == 1 ? 'all' : 'me';
                \Yii::$app->session->setFlash('success', 'Статус изменен.');

            } else {
                \Yii::$app->session->setFlash('danger', 'Статус не изменен.');
            }
        }
    }

    /**
     * Поднятие объявления updated_at Service models.
     * @return mixed
     */
    public function actionChangeUp()
    {
        $pay = Arrays::PAYMENTS();
        $post = \Yii::$app->request->post('ads_id');
        if($post){
            $user = Yii::$app->user->getIdentity();
            $model = RealtyRent::findOne(['id'=>$post, 'id_user'=>$user->getId()]);
            $m_user = User::findOne($user->getId());
            $u_account = new UserAccount();
            if($user->account >= $pay['realty_up_pay']){
                $m_user->account = (integer)$user->account - (integer)$pay['realty_up_pay'];
                $model->updated_at = new Expression('NOW()');
                $u_account->id_user = $user->getId();
                $u_account->pay_out = $pay['realty_up_pay'];
                $u_account->invoice = 'REALTY-UP-'. $model->id .'-'. rand(10000,99999);
                $u_account->date = new Expression('NOW()');
                $u_account->description = 'Поднятие объявления о продаже недвижимости №'. $model->id . '.';

                if ($model->save()&&$m_user->save(false)&&$u_account->save()) {
                    $arr = [
                        'account'=>$m_user->account,
                        'pay'=>$pay['realty_up_pay'],
                        'date'=> date_create_immutable() ,
                        'message'=>'Объявление поднято на верх. С вашего счета списано '.$pay['realty_up_pay'].'руб.',
                        'm_type'=>'success'
                    ];
                    echo json_encode($arr);
                } else {
                    $arr = [
                        'message'=>'Объявление не поднято',
                        'm_type'=>'danger'
                    ];
                    echo json_encode($arr);
                }
            }else{
                $arr = [
                    'message'=>'Объявление не поднято. На вашем счёте недостаточно средств.',
                    'm_type'=>'danger'
                ];
                echo json_encode($arr);
            }

        }
    }

    /**
     * Выделение и поднятие объявления vip, updated_at в service models.
     * @return mixed
     */
    public function actionChangeVip()
    {
        $pay = Arrays::PAYMENTS();
        $period = Arrays::getConst();
        $post = \Yii::$app->request->post('ads_id');
        if($post){
            $user = Yii::$app->user->getIdentity();
            $model = RealtyRent::findOne(['id'=>$post, 'id_user'=>$user->getId()]);
            $m_user = User::findOne($user->getId());
            $u_account = new UserAccount();
            if($user->account >= $pay['realty_vip_pay']){
                $m_user->account = (integer)$m_user->account - (integer)$pay['realty_vip_pay'];
                $u_account->id_user = $user->getId();
                $u_account->pay_out = $pay['realty_vip_pay'];
                $u_account->invoice = 'REALTY-VIP-'. $model->id .'-'. rand(10000,99999);
                $u_account->date = new Expression('NOW()');
                $u_account->description = 'Выделение объявления о продаже недвижимости №'. $model->id . '.';
                $model->vip_date = new Expression('NOW()');
                $model->updated_at = new Expression('NOW()');
                if ($model->save()&&$m_user->save(false)&&$u_account->save()) {
                    $arr = [
                        'account'=>$m_user->account,
                        'pay'=>$pay['realty_vip_pay'],
                        'date'=> date_create_immutable() ,
                        'message'=>'Объявление выделено на ( '.$period['vip'].' )дней и поднято на верх. С вашего счета списано '.$pay['realty_vip_pay'].'руб.',
                        'm_type'=>'success'
                    ];
                    echo json_encode($arr);
                } else {
                    $arr = [
                        'message'=>'Объявление не выделено и не поднято.',
                        'm_type'=>'danger'
                    ];
                    echo json_encode($arr);
                }
            }else{
                $arr = [
                    'message'=>'Объявление не выделено и не поднято. На вашем счёте недостаточно средств.',
                    'm_type'=>'danger'
                ];
                echo json_encode($arr);
            }

        }
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RealtyRent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}