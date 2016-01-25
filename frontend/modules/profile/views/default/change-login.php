<?php
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use \common\models\users\User;


if(User::isCompany()){
	$btn_change_username = 'Введите новое имя компании';
}else{
	$btn_change_username = 'Введите новый логин';
}
?>

	<div class="change-login" <div class="container-fluid" style="padding: 25px 10px 25px 10px;">
	<div class="container-fluid">
		<button class="close" aria-label="Close" data-dismiss="modal" type="button">
			<span aria-hidden="true">×</span>
		</button>
		<header style="margin-bottom: 20px;"><?= User::isCompany() ? 'Изменение компании.' : 'Изменение логина.' ?></header>

		<?php $form = ActiveForm::begin(['id' => 'change-login', 'class' => '']); ?>

		<?= $form->field($user, 'username')->textInput()->label('<i>'.$btn_change_username.'</i>') ?>

		<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right', 'name' => 'change-password-button']) ?>

		<?php ActiveForm::end(); ?>
	</div>
</div>
<?php

	?>