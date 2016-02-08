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
use yii\web\View;
use \yii\bootstrap\Widget;
use common\models\goods\GoodsCat;

class CategGoodsVMenu extends Widget
{
    public function run($level = 0){
        $cat = GoodsCat::find()
            ->select(['id', 'root', 'lft', 'rgt', 'lvl', 'name', 'icon', 'alias'])
            ->where(['active' => 1, 'visible' => 1])
            ->asArray()
            ->orderBy('lft')
            ->orderBy('root')
            ->all();
        self::registerCss();
        echo '<div class="v-menu">';
        echo '<div class="v-menu-header">';
        echo '<h3 style="margin: 0; color: #fff;">';
        echo Html::a('<i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;Каталог товаров',['/goods/goods/index'],['style'=>'color:#fff; text-decoration:none; font-size: 0.9em;']);
        echo '</h3>';
        echo '</div>';
        echo Html::a('<i class="fa fa-plus"></i>&nbsp;&nbsp;Подать объявление', ['/goods/goods/create'], ['class' => 'btn-u btn-u-orange cat-button','style'=>'padding: 5px 7px 5px 7px; text-align:center; font-size:15px; width:100%;']);
        echo '<div id="vertical" class="hovermenu ttmenu dark-style menu-color-gradient" style="margin: 0px 0px 0px 0px;">';
        echo '<div class="navbar navbar-default" role="navigation" style="margin: 0;">';
        echo '<div class="navbar-header">';
        echo '<button class="navbar-toggle collapsed" data-target=".navbar-collapse" data-toggle="collapse" type="button">';
        echo '<a class="navbar-brand" href="#">';
        echo '<i class="fa fa-bars">&nbsp;&nbsp;Категории: </i>';
        echo '</a>';
        echo '</div>';

        echo '<div id="v-menu" class="navbar-collapse collapse">';

        echo self::tree($cat,$level);

        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        self::registerJs();
    }

    private static function activeCategory(){
        $get = Yii::$app->request->get('cat');
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

    private function tree($cat, $level)
    {
        $activ_el = self::activeCategory();
        $path = Url::to('/goods/goods/index');
        echo '<ul class="nav navbar-nav">';
        foreach($cat as $node){
            if($node['lvl'] == $level){
                echo '</li>';
            }elseif($node['lvl']>$level){
                if($node['lvl'] == 1) {
                    echo '<ul class="dropdown-menu vertical-menu">';
                    echo '<li>';
                }elseif($node['lvl'] == 2){
                    echo '<ul>';
                }else{
                    echo '<ul>';
                }
            }else{
                echo '</li>';
                for($i = $level - $node['lvl']; $i; $i--){
                    echo '</ul>';
                    echo '</li>';
                }
            }
            if($node['lvl'] == 0){
                echo '<li class="dropdown">';
            }elseif($node['lvl'] == 1){
                echo '<li>';
            }
            if($node['lvl'] == 0){
                if($node['alias'] == $activ_el){
                    echo Html::a($node['name'].'<b class="dropme"></b>',[$path, 'cat'=>$node['alias']], ['data-toggle'=>'dropdown','class'=>'dropdown-toggle active']);
                }else{
                    echo Html::a($node['name'].'<b class="dropme"></b>',[$path, 'cat'=>$node['alias']], ['data-toggle'=>'dropdown','class'=>'dropdown-toggle']);
                }
            }elseif($node['lvl'] == 1){
                echo Html::a($node['name'],[$path, 'cat'=>$node['alias']]);
            }
            $level = $node['lvl'];
        }
        for($i = $level; $i; $i--){
            //echo '</li>';
            if($node['lvl'] == 1){
                echo '</li>';
            }
            echo '</ul>';
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

<!-- Begin Sidebar Menu

    <ul class="list-group sidebar-nav-v1 fa-fixed" id="sidebar-nav">
        <!-- Typography
        <li class="list-group-item list-toggle">
            <a data-toggle="collapse" data-parent="#sidebar-nav" href="#collapse-typography">Typography</a>
            <ul id="collapse-typography" class="collapse">
                <li><a href="shortcode_typo_general.html"><i class="fa fa-sort-alpha-asc"></i> General Typography</a></li>
                <li>
                    <span class="badge badge-u">New</span>
                    <a href="shortcode_typo_headings.html"><i class="fa fa-magic"></i> Heading Options</a>
                </li>
                <li>
                    <span class="badge badge-u">New</span>
                    <a href="shortcode_typo_dividers.html"><i class="fa fa-ellipsis-h"></i> Dividers</a>
                </li>
                <li><a href="shortcode_typo_blockquote.html"><i class="fa fa-quote-left"></i> Blockquote Blocks</a></li>
                <li>
                    <span class="badge badge-u">New</span>
                    <a href="shortcode_typo_boxshadows.html"><i class="fa fa-asterisk"></i> Box Shadows</a>
                </li>
                <li><a href="shortcode_typo_testimonials.html"><i class="fa fa-comments"></i> Testimonials</a></li>
                <li><a href="shortcode_typo_tagline_boxes.html"><i class="fa fa-tasks"></i> Tagline Boxes</a></li>
                <li><a href="shortcode_typo_grid.html"><i class="fa fa-align-justify"></i> Grid Layout</a></li>
            </ul>
        </li>
        <!-- End Typography -->
<!--   </ul>

 End Sidebar Menu -->