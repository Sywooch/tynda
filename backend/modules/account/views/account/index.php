<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\users\BUserAccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Accounts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-account-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User Account', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_user',
            'pay_in',
            'pay_out',
            'pay_in_with_percent',
            // 'invoice',
            // 'date',
            // 'description',
            // 'service',
            // 'yandexPaymentId',
            // 'invoiceId',
            // 'paymentType',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
