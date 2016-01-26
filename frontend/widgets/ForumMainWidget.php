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
use common\models\forum\ForumMessage;
use common\helpers\Sort;
use common\widgets\Arrays;
use frontend\widgets\Avatar;

class ForumMainWidget extends Widget
{


    public function show($count_item = 4)
    {

        $forum = ForumMessage::find()//получаем массив с новостями
        ->select('message,id,created_at,id_cat,id_author,id_theme')
            ->with('idCat')
            ->with('idAuthor')
            ->with('idTheme')
            ->asArray()
            ->where(['status' => 1])
            //->orWhere(['status' => 2])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit($count_item)
            ->all();

        if (is_array($forum) && !empty($forum)) {
            echo '<table class="main-table">';
            echo '<th colspan="2">';
            echo '<span class="title-underblock title-bottom-border dark">Последние сообщения на форуме</span>';
            echo '</th>';
            foreach ($forum as $item) {
                echo '<tr>';
                $path = '/forum/forum/theme';
                echo '<td class="table-img" style="padding: 10px;">';
                echo Html::a(Avatar::userAvatar($item['idAuthor']['avatar'],'80px; border: 1px solid #c6c6c6; padding: 1px;'), [$path, 'id' => $item['idTheme']['alias']]);
                echo '</td>';
                echo '<td style="padding: 10px;">';
                echo Html::a(substr($item['message'],0,128) . ' ...', [$path, 'id' => $item['idTheme']['alias']], ['class' => '', 'style' => 'margin-left: 0px;', 'title' => 'Подробнее']);
                echo '<br><i class="small-text" >Тема:</i> '. Html::a($item['idTheme']['name'],['/forum/forum/theme/','id'=>$item['idTheme']['alias']]);
                echo '<br><i class="small-text" >Категория:</i> '. Html::a($item['idCat']['name'],['/forum/forum/category/','id'=>$item['idCat']['alias']]);

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
