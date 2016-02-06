<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 20.07.2015
 * Time: 16:29
 */

namespace frontend\widgets;


use common\models\forum\VForumMessages;
use Yii;
use yii\caching\DbDependency;
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\bootstrap\Widget;
use common\widgets\Arrays;
use common\helpers\Sort;
use frontend\widgets\Avatar;

class ForumMainWidget extends Widget
{


    public function show($count_item = 10)
    {
        $dependency = new DbDependency();
        $dependency->sql = 'SELECT MAX(id) FROM forum_message';
        $forum = VForumMessages::getDb()->cache(function ($db){
                return VForumMessages::find()
                ->asArray()
                ->where(['status' => 1])
                ->limit(5)
                ->all();
        }, Arrays::CASH_TIME, $dependency);

        if (is_array($forum) && !empty($forum)) {
            echo '<table class="main-table">';
            echo '<th colspan="2">';
            echo '<span class="title-underblock title-bottom-border dark">Последние сообщения на форуме&nbsp;&nbsp;&nbsp;';
            echo Html::a('на форум', ['/forum/forum/index'],['class'=>'small-text']);
            echo '</span>';
            echo '</th>';
            foreach ($forum as $item) {
                echo '<tr>';
                $path = '/forum/forum/theme';
                echo '<td class="table-img">';
                echo Html::a(Avatar::userAvatar($item['avatar'],'80px; border: 1px solid #c6c6c6; padding: 1px;'), [$path, 'id' => $item['theme_alias']]);
                echo '</td>';
                echo '<td>';
                echo Html::a(substr($item['message'],0,80) . ' ...', [$path, 'id' => $item['idTheme']['alias']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
                echo '<br><i class="small-text" >Тема:</i> '. Html::a($item['theme_name'],['/forum/forum/theme/','id'=>$item['theme_alias']]);
                echo '<br><i class="small-text" >Категория:</i> '. Html::a($item['category'],['/forum/forum/category/','id'=>$item['cat_alias']]);

                echo '</td>';
                echo '</tr>';
            }
            echo '</table>';

            //echo '<pre>';
            //print_r($forum);
            //echo '</pre>';
        } // END IF
    }

}
