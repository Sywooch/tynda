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
use common\models\afisha\Afisha;
use common\helpers\Sort;
use common\widgets\Arrays;
use frontend\widgets\Avatar;

class AfishaMainWidget extends Widget
{


    public function show($count_item = 3)
    {

        $afisha = Afisha::find()//получаем массив с новостями
        ->select('title,alias,id,publish,thumbnail,id_cat')
            ->with('tags')
            ->with('cat')
            ->asArray()
            ->where(['status' => 1])
            ->andWhere('(publish < NOW() AND (unpublish < NOW()OR unpublish IS NULL))')
            ->orderBy(['publish' => SORT_DESC])
            ->limit($count_item)
            ->all();
        if (is_array($afisha) && !empty($afisha)) {
            echo '<table class="main-table">';
            echo '<th colspan="2">';
            echo '<span class="title-underblock title-bottom-border dark">Афиша</span>';
            echo '</th>';
            foreach ($afisha as $item) {
                echo '<tr>';
                $path = '/afisha/afisha/view';
                echo '<td class="table-img">';
                echo Html::a(Avatar::imgAfisha($item['thumbnail'],'111px; border: 1px solid #c6c6c6; padding: 1px;'), [$path, 'id' => $item['alias']]);
                echo '</td>';
                echo '<td>';
                echo Html::a($item['title'], [$path, 'id' => $item['alias']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
                echo '<br><i class="small-text" >Категория:</i> '. Html::a($item['cat']['name'],['/afisha/afisha/index/','cat'=>$item['cat']['alias']]);
                echo '<ul class="list-inline"><li class="tag-sign" style="margin-right: 5px;">Теги: </li>';
                foreach( $item['tags'] as $tag ){
                    echo '<li class="tag-name">';
                    echo Html::a($tag['name'],['/tags/tags/index', 'tag'=>$tag['name']],['class'=>'']);
                    echo '</li>';
                }
                echo '</ul>';
                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';

            //echo '<pre>';
            //print_r($afisha);
            //echo '</pre>';
        } // END IF
    }

}
