<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 19.07.2015
 * Time: 1:39
 */

namespace frontend\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\bootstrap\Widget;
use common\models\news\News;


class NewsSidebarWidget extends Widget
{
    public function init()
    {
        $news_m = News::find()
            ->where(['status' => 1])
            ->andWhere('(publish < NOW() AND (unpublish < NOW()OR unpublish IS NULL))')
            ->orderBy(['publish' => SORT_DESC])
            ->limit(5)
            ->all();

        $path = Url::to('/news/news/view');
        echo '<div class="panel panel-u" style="margin-top: 10px;">';
        echo '<div class="panel-heading">';
        echo '<h3 class="panel-title" style="color: #fff; display: block;">Последние новости</h3>';
        echo '</div>';
        echo '<div class="posts panel-body" style=" padding: 7px;">';
        foreach ($news_m as $news) {
            echo '<dl class="dl-horizontal">';
            echo '<dt>';
            echo '<a href="' . $path . '?id=' . $news->alias . '">';
            echo Html::img(Url::home() . 'img/news/' . $news->thumbnail, ['style' => '']);
            echo '</a>';
            echo '</dt>';
            echo '<dd>';
            echo Html::a($news->title, [$path, 'id' => $news->alias],['style'=>'font-size: 0.9em;']);
            echo '<br><i style="font-size: 0.9em; color: #aaa;">' . Yii::$app->formatter->asDate($news->publish, 'long') . '</i>';
            echo '</dd>';
            echo '</dl>';
        }
        echo '</div>';
        echo '</div>';
    }
}