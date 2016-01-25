<?php
/**
 * Created by PhpStorm.
 * User: Администратор
 * Date: 11.06.2015
 * Time: 18:45
 */

namespace frontend\widgets;
use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use \yii\bootstrap\Widget;
use yii\web\View;
use common\models\forum\Forums;
use common\models\forum\ForumCat;

class CategForum extends Widget
{
    public function run(){
        $cat = Forums::find()->with('forumCats')->where(['status'=>1])->asArray()->all();
       // echo '<pre>';
       // print_r($cat);
       // echo '</pre>';
        self::registerCss();
        echo '<div style="display: block; content: \' \'; padding: 2px; margin: 5px 0px; background-color: #d9d9d9;">';
        echo '<div  style="margin: 0px 0px 2px 0px; width: 100%; display: block; background-color: #9C0000; padding: 7px 18px;">';
        echo '<h3 style="margin: 0; color: #fff;">';
        echo Html::a('<i class="fa fa-heartbeat"></i>&nbsp;&nbsp;Все категории',['/forum/forum/index'],['style'=>'color:#fff; text-decoration:none; font-size: 0.9em;']);
        echo '</h3>';
        echo '</div>';
        echo '<div id="vertical" class="hovermenu ttmenu dark-style menu-color-gradient" style="margin: 0px 0px 0px 0px;">';
        echo '<div class="navbar navbar-default" role="navigation" style="margin: 0;">';
        echo '<div class="navbar-header">';
        echo '<button class="navbar-toggle collapsed" data-target=".navbar-collapse" data-toggle="collapse" type="button">';
        echo '<a class="navbar-brand" href="#">';
        echo '<i class="fa fa-bars">&nbsp;&nbsp;Форумы </i>';
        echo '</a>';
        echo '</div>';

        echo '<div id="v-menu" class="navbar-collapse collapse">';

        echo self::tree($cat);

        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        self::registerJs();
    }

    private static function activeCategory(){
        $get = Yii::$app->request->get('category');
        $session = Yii::$app->session;
        $session->open();
        $active_cat = $session->get('parent_cat');
        $session->close();

        if(!empty($active_cat)){
            foreach($active_cat as $item){
                if($item['lvl'] == 0){
                    $act_el = $item['alias']; break;
                }elseif($item['rgt']-$item['lft'] == 1){
                    $act_el = $item['alias'];
                }
            }
            return $act_el;
        }elseif(isset($get)){
            return $get;
        }else{
            return false;
        }
    }

    private function tree($cat)
    {
        $level = 0;
        $activ_el = self::activeCategory();
        $path = Url::to('/forum/forum/index');
        echo '<ul class="nav navbar-nav">';
        foreach($cat as $node) {
            if (empty($node['forumCats'])) {
                echo '<li class="dropdown hovernav">';
                if ($node['alias'] == $activ_el) {
                    echo Html::a($node['name'] . '<b class="dropme"></b>', [$path, 'category' => $node['alias']], ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle active']);
                } else {
                    echo Html::a($node['name'] . '<b class="dropme"></b>', [$path, 'category' => $node['alias']], ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle']);
                }
            } else {
                echo '<li class="dropdown hovernav">';
                if ($node['alias'] == $activ_el) {
                    echo Html::a($node['name'] . '<b class="dropme"></b>', [$path, 'category' => $node['alias']], ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle active']);
                } else {
                    echo Html::a($node['name'] . '<b class="dropme"></b>', [$path, 'category' => $node['alias']], ['data-toggle' => 'dropdown', 'class' => 'dropdown-toggle']);
                }
                echo '<ul class="dropdown-menu vertical-menu">';
                foreach ($node['forumCats'] as $item) {
                    echo '<li>';
                    echo Html::a($item['name'], ['/forum/forum/category', 'id' => $item['alias']]);
                    echo '</li>';
                }
                echo '</ul>';
            }
            echo '</li>';
        }
        echo '</ul>';
    }

    private function registerCss(){
        $this->registerCssFile('/css/menu/menu.css', ['depends' => [\yii\web\YiiAsset::className()]]);
    }

    private  function registerJs(){
        $js = <<< JS
    $(document).ready(function () {

});
JS;
        $this->registerJsFile('/js/menu/ttmenu.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJsFile('/js/menu/jquery.fitvids.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJsFile('/js/menu/hovernav.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJs($js, View::POS_END);
    }

}

?>