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
use common\models\realty\VRealtySale;
use common\helpers\Sort;
use common\widgets\Arrays;
use frontend\widgets\Avatar;

class RealtySaleMainWidget extends Widget
{


    public function show($count_item = 4)
    {

        $realty = VRealtySale::find()//получаем массив с новостями
        ->select('name,id,id_cat,category,alias,created_at,main_img,cost')
            ->asArray()
            ->where(['status' => 1])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($count_item)
            ->all();
        if (is_array($realty) && !empty($realty)) {
            echo '<table class="main-table">';
            echo '<th colspan="2">';
            echo '<span class="title-underblock title-bottom-border dark">Недвижимость продажа</span>';
            echo '</th>';
            foreach ($realty as $item) {
                echo '<tr>';
                $path = '/realty/sale/view';
                echo '<td class="table-img" style="padding: 10px;">';
                echo Html::a(Avatar::imgRealtySale($item['main_img'],'80px; border: 1px solid #c6c6c6; padding: 1px;'), [$path, 'id' => $item['id']]);
                echo '</td>';
                echo '<td style="padding: 10px;">';
                echo Html::a($item['name'], [$path, 'id' => $item['id']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
                if($item['cost'] != ''){
                    echo '<br><i class="small-text" style="margin-right: 5px;">Цена:</i><strong class="cost">'.number_format($item['cost'],2,',',' ').'</strong><i class="small-text" style="margin-left: 2px;">руб.</i>';
                }
                echo '<br><i class="small-text" >Категория:</i> '. Html::a($item['category'],['/realty/sale/index/','cat'=>$item['alias']]);
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';

            //echo '<pre>';
            //print_r($realty);
            //echo '</pre>';
        } // END IF
    }

}
