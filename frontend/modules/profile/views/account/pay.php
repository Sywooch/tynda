<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\users\UserAccount */
/* @var $form yii\widgets\ActiveForm */
$this->params['left'] = true;
$paymentMethod = [
    ['id' => 'PC', 'name' => 'Со счета в Яндекс Деньгах'],
    ['id' => 'AC', 'name' => 'С банковской карты']
];
$methods = \yii\helpers\ArrayHelper::map($paymentMethod, 'id', 'name');

?>

<div class="user-account-form">

    <?php $form = ActiveForm::begin([
        'action' => 'https://demomoney.yandex.ru/eshop.xml', // 'https://money.yandex.ru/eshop.xml',
        'method' => 'POST',
        'id' => 'payment_form',
        'options' => [
            'class' => 'sky-form',
        ],
    ]); ?>

    <!-- Обязательные поля -->
    <input name="shopId" value="151" type="hidden"/>
    <input name="shopArticleId" value="151" type="hidden"/>
    <input name="scid" value="59816" type="hidden"/>

    <input name="customerNumber" value="100500" type="hidden"/>

    <section>
        <label class="control-label" for="paymentType">Внесите сумму в рублях на которую хотите пополнить свой счет</label>
        <?= Html::textInput('sum', 100, ['id' => 'sum', 'class' => 'form-control']) ?>
    </section>
    <section>
        <label class="control-label" for="paymentType">Выберите способ оплаты</label>
        <?= Html::dropDownList('paymentType', '', $methods, ['id' => 'paymentType', 'class' => 'form-control']) ?>
    </section>


    <input type="hidden" name="rebillingOn" value="true">

    <div class="form-group">
        <?= Html::submitButton('Оплатить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
