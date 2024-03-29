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
use common\models\goods\Goods;
use common\helpers\Sort;
use common\widgets\Arrays;
use frontend\widgets\Avatar;

class GoodsMainWidget extends Widget
{


    public function show($count_item = 4)
    {

        $goods = Goods::find()//получаем массив с новостями
        ->select('name,id,id_cat,created_at,main_img,cost')
            ->with('cat')
            ->asArray()
            ->where(['status' => 1])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($count_item)
            ->all();
        if (is_array($goods) && !empty($goods)) {
            echo '<table class="main-table">';
            echo '<th colspan="2">';
            echo '<span class="title-underblock title-bottom-border dark">Новые товары</span>';
            echo '</th>';
            foreach ($goods as $item) {
                echo '<tr>';
                $path = '/goods/goods/view';
                echo '<td class="table-img">';
                echo Html::a(Avatar::imgGoods($item['main_img'],'80px; border: 1px solid #c6c6c6; padding: 1px;'), [$path, 'id' => $item['id']]);
                echo '</td>';
                echo '<td>';
                echo Html::a($item['name'], [$path, 'id' => $item['id']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
                if($item['cost'] != ''){
                    echo '<br><i class="small-text" style="margin-right: 5px;">Цена:</i><strong class="cost">'.number_format($item['cost'],2,',',' ').'</strong><i class="small-text" style="margin-left: 2px;">руб.</i>';
                }
                echo '<br><i class="small-text" >Категория:</i> '. Html::a($item['cat']['name'],['/goods/goods/index/','cat'=>$item['cat']['alias']]);
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';

            //echo '<pre>';
            //print_r($goods);
            //echo '</pre>';
        } // END IF
    }

}
