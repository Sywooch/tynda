<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use common\widgets\Arrays;
use kartik\widgets\SwitchInput;

$this->title = 'Регистрация';
?>
<div class="site-signup">

	<br>

	<div class="row">
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
			<div class="panel panel-u">
				<div class="panel-heading">
					<h1 style="align-content: center; color: #fff;" id="how_signup" class="panel-title">Регистрация частного лица</h1>
				</div>
				<div class="panel-body">

					<?php $form = ActiveForm::begin([
						'id' => 'form-signup',
						'options' => [
							'class' => 'reg-page',
						]]); ?>
					<label class="control-label">Выберите как вы хотите зарегистрироваться:</label>
					<?= $form->field($model, 'company')->widget(SwitchInput::classname(), [
						'pluginOptions' => [
							'handleWidth' => 120,
							'onColor' => 'primary',
							'offColor' => 'primary',
							'labelText' => '<i id="lbl-text">как компания</i>',
							'onText' => 'как компания',
							'offText' => 'как частное лицо'
						],
						'pluginEvents' => [
							'switchChange.bootstrapSwitch' => 'function(element, options) {
                            if(options){
                                isCompany();
                            }else{
                                isPerson();
                            }
                        }',
						],
					])->label(false); ?>


					<?= $form->field($model, 'email', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'email', 'type' => 'email']])->label('Укажите свой email для связи.') ?>
					<?= $form->field($model, 'tel', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'в формате +79XXXXXX', 'type' => 'tel']])->label('Укажите номер сотового телефона для связи.') ?>
					<?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control', 'placeholder' => 'минимум 6 символов']])->passwordInput()->label('Пароль') ?>

					<label id="fio">Уточните пожалуйста свои данные</label>

					<?= $form->field($model, 'username')->label('Ваше имя') ?>
					<div id="s_name" style="display: none;">
						<?= $form->field($model, 'name')->label('Имя контактного лица') ?>
					</div>


					<div class="col-sm-6 no-side">
						<?= $form->field($model, 'surname')->label('Фамилия') ?>
					</div>
					<div class="col-sm-6 no-side">
						<?= $form->field($model, 'patronym')->label('Отчество') ?>
					</div>

					<div class="col-sm-12 no-side" style="display: block; content: ' ';">
						<i>Докажите что Вы не робот :-)</i>
						<div class="g-recaptcha" data-sitekey="<?= \common\widgets\captcha\Captcha::getKey() ?>"></div>
						<br>
					</div>
					<div class="col-sm-12 no-side" style="padding: 3px;">
						<i class="small-text">Нажимая кнопку зарегистрироваться Вы даете свое <?= Html::a('согласие на использование персональных данных', ['/page/page/view','id'=>'soglasie-na-obrabotku-personalnyh-dannyh-polzovatelej'],['target'=>'_blank']) ?>. </i>
					</div>

					<div class="form-group">
						<?= Html::submitButton('Зарегистрироваться', ['class' => 'btn-u btn-block btn-u-dark', 'name' => 'signup-button']) ?>
					</div>

					<?php ActiveForm::end(); ?>
				</div>
			</div>
			<div class="row tag-box tag-box-v5" style="margin-bottom: 30px;">
				<h5>Если уже зарегистрированы нажмите</h5>
				<?= Html::a('Войти', '/site/login', ['class' => 'btn-u btn-block btn-u-dark']) ?>
			</div>
		</div>
	</div>
</div>
<script src='https://www.google.com/recaptcha/api.js?hl=<?= \common\widgets\captcha\Captcha::getLanguage() ?>'></script>
<?php
$this->registerCss('.form-group{margin-bottom: 0px;}');
$this->registerJsFile('/js/signup.js', ['depends' => [\yii\web\YiiAsset::className()]]);


?>
