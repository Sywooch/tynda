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
use common\models\news\News;
use common\helpers\Sort;
use common\widgets\Arrays;
use frontend\widgets\Avatar;

class NewsMainWidget extends Widget
{


    public function show($count_item = 3)
    {

        $news = News::find()//получаем массив с новостями
        ->select('title,alias,id,publish,thumbnail,id_cat')
            ->with('tags')
            ->with('cat')
            ->asArray()
            ->where(['status' => 1])
            ->andWhere('(publish < NOW() AND (unpublish < NOW()OR unpublish IS NULL))')
            ->orderBy(['publish' => SORT_DESC])
            ->limit($count_item)
            ->all();
        if (is_array($news) && !empty($news)) {
            echo '<table class="main-table">';
            echo '<th colspan="2">';
                    echo '<span class="title-underblock title-bottom-border dark"></span>';
            echo '</th>';
            foreach ($news as $item) {
                echo '<tr>';
                $path = '/news/news/view';
                echo '<td class="news-img" style="padding: 7px 0px 7px 10px; width: 115px;">';
                echo Html::a(Avatar::imgNews($item['thumbnail'],'95px; border: 1px solid #c6c6c6; padding: 1px;'), [$path, 'id' => $item['alias']]);
                echo '</td>';
                echo '<td style="padding: 10px 10px 10px 0px;">';
                echo Html::a($item['title'], [$path, 'id' => $item['alias']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
                echo '<br><i class="small-text" >Категория:</i> '. Html::a($item['cat']['name'],['/news/news/index/','cat'=>$item['cat']['alias']]);
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
            //print_r($news);
            //echo '</pre>';
        } // END IF
    }

}
