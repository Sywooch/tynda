<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\users\UserAccount */
/* @var $form yii\widgets\ActiveForm */
$this->params['left'] = true;
$paymentMethod = [
    ['id' => 'PC', 'name' => 'Со счета в Яндекс Деньгах'],
    ['id' => 'AC', 'name' => 'С банковской карты'],
    ['id' => 'GP', 'name' => 'Наличными']
];
$methods = \yii\helpers\ArrayHelper::map($paymentMethod, 'id', 'name');
$user = Yii::$app->user->getIdentity();

?>

<div class="user-account-form">

    <?php $form = ActiveForm::begin([
        'action' => $settings->form_action, // 'https://money.yandex.ru/eshop.xml',
        'method' => 'POST',
        'id' => 'payment_form',
        'options' => [
            'class' => '',
            'target' => '_blank',
        ],
    ]); ?>


    <!-- ОБЯЗАТЕЛЬНАНЫЕ ПОЛЯ (все параметры яндекс.кассы регистрозависимые) -->
    <input type="hidden" name="shopId" value="<?=$settings->SHOP_ID?>">
    <!--<input name="shopArticleId" value="<?=$settings->SHOP_ID?>" type="hidden"/> -->
    <input type="hidden" name="scid" value="<?=$settings->SCID?>">
    <input type="hidden" name="customerNumber" size="64" value="<?= $user->email ?>"><br><br>
    <label>Идентификатор клиента:</label>
    <?= $user->email ?><br>
    <section>
        <label class="control-label" for="paymentType">Внесите сумму в рублях на которую хотите пополнить свой счет (руб.):</label>
        <?= Html::textInput('sum', 100, ['id' => 'sum', 'class' => 'form-control']) ?>
    </section>
    <!-- CustomerNumber -- до 64 символов; идентификатор плательщика в ИС Контрагента.
	В качестве идентификатора может использоваться номер договора плательщика, логин плательщика и т.п.
	Возможна повторная оплата по одному и тому же идентификатору плательщика.

	sum -- сумма заказа в рублях.
	-->

    <!-- необязательные поля (все параметры яндекс.кассы регистрозависимые) -->
    <input name="orderNumber" value="order777" type="hidden"/>
    <input name="cps_phone" value="79110000000" type="hidden"/>
    <input name="cps_email" value="user@domain.com" type="hidden"/>

    <!-- Внимание! Для тестирования в ДЕМО-среде доступны только два метода оплаты: тестовый Яндекс.Кошелек и Тестовая банковская карта
	-->

    <section>
        <label class="control-label" for="paymentType">Выберите способ оплаты</label>
        <?= Html::dropDownList('paymentType', '', $methods, ['id' => 'paymentType', 'class' => 'form-control']) ?>
    </section>


    <!--<input type="hidden" name="rebillingOn" value="true">-->
    <br>
    <div class="form-group">
        <?= Html::submitButton('Оплатить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
