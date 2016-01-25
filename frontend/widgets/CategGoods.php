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

class CategGoods extends Widget
{
    public function run($level = 0){
        $cat = GoodsCat::find()
            ->select(['id', 'root', 'lft', 'rgt', 'lvl', 'name', 'icon', 'alias'])
            ->where(['active' => 1, 'disabled' => 0, 'visible' => 1])
            ->asArray()
            ->orderBy('lft')
            ->orderBy('root')
            ->all();
        self::registerCss();
        echo '<div class="thumbnail" style="margin: 15px 0px 5px 0px; display: block;">';
        echo '<h2 class="heading-sm" style="margin: 0px 0px 5px 0px; display: block;">';
        echo '<i class="icon-custom icon-sm icon-color-dark fa fa-hospital-o" style="margin-bottom: 0;"></i>';
        echo '<span>Категории: </span>';
        echo '</h2>';
        echo '<div id="tree-wrapper" class="tree-wrapper " style="position: relative;">';
        echo self::tree($cat,$level);
        echo '</div>';
        echo '</div>';
        self::registerJs();
    }

    private static function activeCategory(){
        $session = Yii::$app->session;
        $session->open();
        $active_cat = $session->get('goods_cat');
        $session->close();

        if($active_cat){
            foreach($active_cat as $item){
                if($item['lvl'] == 0){
                    $ac_id = $item['id']; break;
                }elseif($item['rgt']-$item['lft'] == 1){
                    $ac_id = $item['id'];
                }
            }
            echo 'activ id: '. $ac_id;
            echo '<pre>';
            print_r($active_cat);
            echo '</pre>';

            return $ac_id;
        }else{
            return false;
        }
    }

    private function tree($cat, $level)
    {
        $activ_id = self::activeCategory();
        $path = Url::home().'goods/index';
        echo '<ul class="ul-treefree ul-dropfree">';
        foreach($cat as $node){
            if($node['lvl'] == $level){
                echo '</li>';
            }elseif($node['lvl']>$level){
                echo '<ul>';
            }else{
                echo '</li>';
                for($i = $level - $node['lvl']; $i; $i--){
                    echo '</ul>';
                    echo '</li>';
                }
            }
            echo '<li>';
            if($activ_id == $node['id']){
                echo Html::a($node['name'],[$path, 'cat'=>$node['alias']],['style'=>'background-color: #ddd;']);
            }else{
                echo Html::a($node['name'],[$path, 'cat'=>$node['alias']]);
            }
            $level = $node['lvl'];
        }
        for($i = $level; $i; $i--){
            echo '</li>';
            echo '</ul>';
        }
        echo '</ul>';
    }

    private function registerCss(){
        $css = <<< CSS
        .tree-wrapper{
            height: 450px;
            overflow: auto;
            margin-top: 0px;
        }
        /* ul-treefree */
        ul.ul-treefree { padding-left:7px; }
        ul.ul-treefree ul { margin:0; padding-left:6px; }
        ul.ul-treefree li { position:relative; list-style:none outside none; border-left:solid 1px #999; margin:0; padding:0 0 0 19px; line-height:23px; font-size: 14px;}
        ul.ul-treefree li:before { content:''; display:block; border-bottom:solid 1px #999; position:absolute; width:18px; height:11px; left:0; top:0; }
        ul.ul-treefree li:last-child { border-left:0 none; }
        ul.ul-treefree li:last-child:before { border-left:solid 1px #999; }

        /* ul-dropfree */
        ul.ul-dropfree div.drop {
            width:11px;
            height:11px;
            position:absolute;
            z-index:10;
            top:6px;
            left:-6px;
            background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAALCAIAAAD0nuopAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAE1JREFUeNpinDlzJgNlgAWI09LScEnPmjWLoAImrHpIAkwMFAMqGMGC6X44GzkIsHoQooAFTTVQKdbAwxOigyMsmIh3MC7ASHnqBAgwAD4CGeOiDhXRAAAAAElFTkSuQmCC');
            background-position:-11px 0;
            background-repeat:no-repeat;
            cursor:pointer;
        }
CSS;
        $this->registerCss($css);
    }

    private  function registerJs(){
        $js = <<< JS
    $(document).ready(function(){
        $(".ul-dropfree").find("li:has(ul)").prepend('<div class="drop"></div>');
        $(".ul-dropfree div.drop").click(function() {
            if ($(this).nextAll("ul").css('display')=='none') {
                $(this).nextAll("ul").slideDown(400);
                $(this).css({'background-position':"-11px 0"});
            } else {
                $(this).nextAll("ul").slideUp(400);
                $(this).css({'background-position':"0 0"});
            }
        });
	    $(".ul-dropfree").find("ul").slideUp(400).parents("li").children("div.drop").css({'background-position':"0 0"});
    });
JS;
        $this->registerJsFile('js/jquery-ui.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
        $this->registerJsFile('js/jquery.form.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
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