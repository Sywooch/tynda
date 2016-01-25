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
use common\models\PresCateg;

class CategPres extends Widget
{
    private $categArr = array();

    public function init()
    {
        $menu = PresCateg::find()
            ->select(['id', 'root', 'lft', 'rgt', 'lvl', 'name', 'icon'])
            ->where(['active' => 1, 'disabled' => 0, 'visible' => 1])
            ->asArray()
            ->orderBy('lft')
            ->orderBy('root')
            ->all();

        $session = Yii::$app->session;
        $id_cat = $session->get('cat_id');
        //$session->remove('pres_cat_id');

        $path = Url::home() . 'presentations/index';

        echo '<div class="headline-v2 bg-color-light" style="margin-bottom: 2px;">';
        echo '<h2 style="margin-bottom: 2px;">Категории презентаций</h2>';
        echo '</div>';

        echo '<ul  class="list-group" style="list-style-type: none; padding-left: 0px;">';
        echo '<li class="list-group-item" style="padding: 0px;">';
        echo Html::a('Показать все презентации', [$path], ['class' => 'btn-u btn-u-primary', 'style' => 'width:100%;']);
        echo '</li>';
        foreach ($menu as $n => $item) {
            $active = isset($id_cat) && $id_cat[0] == $item['id'] ? 'btn-u btn-u-dark' : 'btn-u btn-u-default';

            echo '<li class="list-group-item" style="padding: 0px;">';

            if ($item['icon'] != null || $item['icon'] != '') {
                $icon = $item['icon'];
            } elseif ($item['lvl'] == 0) {
                $icon = 'folder-open-o';
            } else {
                $icon = 'caret-right';
            }

            echo Html::a('<span style="padding-left: ' . ($item['lvl'] * 30) . 'px; width:100%;"><i class="fa fa-' . $icon . '"></i>&nbsp;&nbsp;' . $item['name'] . '</span>',
                [$path, 'rt' => $item['root'], 'lk' => $item['lft'], 'rk' => $item['rgt']],
                ['class' => $active, 'style' => 'width:100%; text-align:left;']);
            echo '</li>';

        }
        echo '</ul>';
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