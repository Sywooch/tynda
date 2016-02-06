<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 14.10.2015
 * Time: 17:51
 */

//Avatar::widget()

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use \yii\bootstrap\Widget;
use common\models\slider\SliderMain;
use \common\widgets\Arrays;
use \yii\caching\DbDependency;
class SliderOnMain extends Widget
{
    public function run($path = null, $images = null, $size = null)
    {
        if($images == null && $path == null ){
            $path = Url::to('@frt_url/img/slider/');
            $dependency = new DbDependency();
            $dependency->sql = 'SELECT MAX(id) FROM slider_main';
            $images = SliderMain::getDb()->cache(function ($db){
                return SliderMain::find()->asArray()->where(['status'=>1])->all();
            }, Arrays::CASH_TIME, $dependency);



        }
        self::registerCss();
        if(!empty($images[0])){
            echo '<div id="slider-on-main" class="demo">';
                echo '<div class="item">';
                    echo '<div class="clearfix" style="">';
                    echo '<ul id="image-gallery" class="gallery list-unstyled cS-hidden">';
                        foreach ($images as $_image) {
                            //$path = Url::to('@frt_url/img/realty_sale/');
                            $image = $_image['thumbnail'];
                            echo '<li data-thumb="'.$path.$image.'">';
                            echo '<img src="'.$path.$image.'" style="width: '.$size.' ;" alt="Фото">';
                            echo '<div class="slider-main-sign">';
                            echo '<h2>'.$_image['name'].'</h2>';
                            echo '<div>';
                            echo '</li>';
                        }
                    echo '</ul>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }else{
            if ($size != null) {
                $avtUrl = Url::to('@frt_url/img/no-img.png');
                return Html::img($avtUrl, [
                    'alt' => 'Фото',
                    'style' => 'width:'.$size.';'
                ]);
            } else {
                $avtUrl = Url::to('@frt_url/img/no-img.png');
                return Html::img($avtUrl, [
                    'alt' => 'Фото',
                    'style' => 'width:100%;'
                ]);
            }
        }
        self::registerJs();
        /*echo '<pre>';
        print_r($images);
        echo '<pre>';*/
    }


    private function registerCss(){
        $this->registerCssFile('/plugins/light-slider/css/lightslider.min.css', ['depends' => [\frontend\assets\AppAsset::className()]]);
        $this->registerCssFile('/plugins/light-slider/css/style.css', ['depends' => [\frontend\assets\AppAsset::className()]]);
    }

    private  function registerJs(){
$js = <<< JS
    $(document).ready(function () {
            $('#image-gallery').lightSlider({
                gallery:true,
                item:1,
                thumbItem:9,
                slideMargin: 0,
                pause: 10000,
                speed:800,
                auto:true,
                loop:true,
                onSliderLoad: function() {
                    $('#image-gallery').removeClass('cS-hidden');
                }
            });
    });
JS;
        $this->registerJsFile('/plugins/light-slider/js/lightslider.min.js', ['depends' => [\frontend\assets\AppAsset::className()]]);
        $this->registerJs($js, View::POS_END);
    }
}

?>