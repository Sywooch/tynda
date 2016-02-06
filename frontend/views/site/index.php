<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
use common\models\slider\SliderMain;
use \common\widgets\Arrays;
$this->title = 'Наша тында';

?>
<div class="site-index row" style="margin-top: 10px; margin-bottom: 20px;">
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
			<div class="col-md-4 side_left" style="margin-top: 10px;">
				<?= \frontend\widgets\ForumMainWidget::show(); ?>
			</div>
			<div class="col-md-4 side_left" style="margin-top: 10px;">
				<?= \frontend\widgets\LettersMainWidget::show(); ?>
			</div>
			<div class="col-md-4" style="margin-top: 10px;">
				<?= \frontend\widgets\AfishaMainWidget::show(); ?>
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
