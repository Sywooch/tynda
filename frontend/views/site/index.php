<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use common\models\slider\SliderMain;
use \common\widgets\Arrays;
use app\widgets\DbText;
use yii\helpers\Html;
$this->title = 'Наша тында';

	$this->registerMetaTag(['content' => Html::encode('Городской портал Наша Тында'), 'name' => 'description']);
	$this->registerMetaTag(['content' => Html::encode('Городской портал Наша Тында'), 'name' => 'keywords']);


?>
<div class="site-index row" style="margin-top: 10px; margin-bottom: 20px;">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12 shadow-wrapper">
				<div class="tag-box tag-box-v1 box-shadow shadow-effect-2">
					<?= DbText::widget(['key' => 'text-on-main-comming-soon']) ?>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-7 side_left">
				<?php frontend\widgets\NewsMainWidget::show(); ?>
			</div>
			<div class="col-md-5">
				<?= \frontend\widgets\SliderOnMain::run(); ?>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4" style="margin-top: 10px;">
				<?= \frontend\widgets\AfishaMainWidget::show(); ?>
			</div>
			<div class="col-md-4 side_left" style="margin-top: 10px;">
				<?= \frontend\widgets\LettersMainWidget::show(); ?>
			</div>
			<div class="col-md-4 side_left" style="margin-top: 10px;">
				<?= \frontend\widgets\ForumMainWidget::show(); ?>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 side_left" style="margin-top: 10px;">
				<?= \frontend\widgets\GoodsMainWidget::show(); ?>
			</div>
			<div class="col-md-4 side_left" style="margin-top: 10px;">
				<?= \frontend\widgets\ServiceMainWidget::show(); ?>
			</div>
			<div class="col-md-4" style="margin-top: 10px;">
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-4 side_left" style="margin-top: 10px;">
				<?= \frontend\widgets\RealtySaleMainWidget::show(); ?>
			</div>
			<div class="col-md-4 side_left" style="margin-top: 10px;">
				<?= \frontend\widgets\RealtyRentMainWidget::show(); ?>
			</div>
			<div class="col-md-4" style="margin-top: 10px;">
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">

		</div>
	</div>


</div>
