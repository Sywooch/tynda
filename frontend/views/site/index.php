<?php
/* @var $this yii\web\View */
use yii\helpers\Url;


$this->title = 'Наша тында';
$path = Url::to('@frt_url/img/slider/');
$images = \common\models\slider\SliderMain::find()->asArray()->all();
?>
<div class="site-index row" style="margin-top: 10px; margin-bottom: 20px;">

            <div class="col-md-7 side_left">
                <?php frontend\widgets\NewsMainWidget::show(); ?>
            </div>
            <div class="col-md-5">
                <?= \frontend\widgets\SliderOnMain::run($path, $images, '100%'); ?>
            </div>


            <div class="col-md-4 side_left" style="margin-top: 10px;">
                <?= \frontend\widgets\ForumMainWidget::show(); ?>
                <?= \frontend\widgets\GoodsMainWidget::show(); ?>
                <?= \frontend\widgets\RealtySaleMainWidget::show(); ?>

            </div>
            <div class="col-md-4 side_left" style="margin-top: 10px;">
                <?= \frontend\widgets\LettersMainWidget::show(); ?>
                <?= \frontend\widgets\ServiceMainWidget::show(); ?>
                <?= \frontend\widgets\RealtyRentMainWidget::show(); ?>
            </div>
            <div class="col-md-4" style="margin-top: 10px;">
                <?= \frontend\widgets\AfishaMainWidget::show(); ?>


            </div>
</div>
