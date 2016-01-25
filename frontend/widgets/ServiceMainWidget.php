<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 20.07.2015
 * Time: 16:29
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\bootstrap\Widget;
use common\models\service\Service;
use common\helpers\Sort;
use common\widgets\Arrays;
use frontend\widgets\Avatar;

class ServiceMainWidget extends Widget
{


    public function show($count_item = 4)
    {

        $service = Service::find()//получаем массив с новостями
        ->select('name,id,id_cat,created_at,main_img,cost')
            ->with('cat')
            ->asArray()
            ->where(['status' => 1])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($count_item)
            ->all();
        if (is_array($service) && !empty($service)) {
            echo '<table class="main-table">';
            echo '<th colspan="2">';
                echo 'Услуги';
            echo '</th>';
            foreach ($service as $item) {
                echo '<tr>';
                $path = '/service/service/view';
                echo '<td class="table-img" style="padding: 10px;">';
                echo Html::a(Avatar::imgService($item['main_img'],'80px; border: 1px solid #c6c6c6; padding: 1px;'), [$path, 'id' => $item['id']]);
                echo '</td>';
                echo '<td style="padding: 10px;">';
                echo Html::a($item['name'], [$path, 'id' => $item['id']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
                if($item['cost'] != ''){
                    echo '<br><i class="small-text" style="margin-right: 5px;">Цена:</i><strong class="cost">'.number_format($item['cost'],2,',',' ').'</strong><i class="small-text" style="margin-left: 2px;">руб.</i>';
                }
                echo '<br><i class="small-text" >Категория:</i> '. Html::a($item['cat']['name'],['/service/service/index/','cat'=>$item['cat']['alias']]);
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';

            //echo '<pre>';
            //print_r($service);
            //echo '</pre>';
        } // END IF
    }

}
