<?php

namespace app\modules\profile\controllers;

use Yii;
use common\models\users\UserAccount;
use common\models\users\UserAccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\helpers\YandexKassaSettings as Settings;
use app\modules\profile\yandex\YaMoneyCommonHttpProtocol;
/**
 * AccountController implements the CRUD actions for UserAccount model.
 */
class AccountController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','pay','success','view','fail','check-order','payment-aviso'],
                'rules' => [
                    [
                        'actions' => ['index','pay','success','view','fail','check-order','payment-aviso'],
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
     * Lists all UserAccount models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserAccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $settings = new Settings();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'settings' => $settings,
        ]);
    }

    /**
     * Displays a single UserAccount model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new UserAccount model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionPay()
    {
        $model = new UserAccount();
        $user = Yii::$app->user->getIdentity();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('pay', [
                'model' => $model,
                'user' => $user,
            ]);
        }
    }

    public function actionPaymentAviso(){
        $settings = new Settings();
        $yaMoneyCommonHttpProtocol = new YaMoneyCommonHttpProtocol("paymentAviso", $settings);
        $yaMoneyCommonHttpProtocol->processRequest($_REQUEST);
        exit;
    }

    public function actionCheckOrder(){
        $settings = new Settings();
        $yaMoneyCommonHttpProtocol = new YaMoneyCommonHttpProtocol("checkOrder", $settings);
        $yaMoneyCommonHttpProtocol->processRequest($_REQUEST);
        exit;
    }

    public function actionSuccess(){
        return $this->render('success',[]);
    }
    public function actionFail(){
        return $this->render('fail',[]);
    }
    /**
     * Finds the UserAccount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UserAccount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserAccount::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
