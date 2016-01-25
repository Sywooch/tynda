<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\widgets\Arrays;
use yii\widgets\LinkPager;

$this->params['left'] = true;

$this->title = 'Мои объявления о продаже недвижимости';
$this->params['breadcrumbs'][] = ['label' => 'Мой профиль', 'url' => [Url::home() . 'profile/index']];
$this->params['breadcrumbs'][] = $this->title;
//'education', 'skills', 'about', 'experience'
?>

<div class="jobs-default-index">
    <div class="panel panel-dark">
        <div class="panel-heading">
            <h1 class="panel-title" style="margin: 0px; font-size: 1.2em;"><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <?= Html::a('Мои объявления о продаже недвижимости', ['/realty/sale/my-ads'], ['class' => 'btn-u btn-u-dark-blue']) ?>
            <?= Html::a('Мои объявления об аренде недвижимости', ['/realty/rent/my-ads'], ['class' => 'btn-u btn-u-default']) ?>
            <br>
            <?= Html::a('<i class="fa fa-plus"></i>  Добавить объявление о продаже недвижимости', ['/realty/sale/create'], ['class' => 'btn-u btn-u-dark', 'style'=>'margin-top: 5px;']) ?>
            <?= LinkPager::widget([
            'pagination' => $pages,
            ]); ?>
            <br><br>

            <?php $form = ActiveForm::begin(); ?>
            <div class="container-fluid s-results margin-bottom-50">
                <?php foreach ($model as $item) { ?>
                    <div class="inner-results">
                        <h3 style="margin:0px;"><?= Html::a($item['name'], ['/realty/sale/view', 'id' => $item['id']], []) ?></h3>
                        <ul class="list-inline">
                            <li>
                                <div class="btn-group" style="margin: 5px 0px;">
                                    <?php
                                    if ($item['status'] == 1) {
                                        echo '<span onclick="changeStatus(' . $item['id'] . ')" id="status-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-green" title="Изменить статус на - Видно только мне">Видно всем</span>';
                                        echo '<span onclick="changeUp(' . $item['id'] . ')" id="up-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-orange" title="Поднять объявление на верх">Поднять на верх</span>';
                                        echo '<span onclick="changeVip(' . $item['id'] . ')" id="vip-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-dark-blue" title="Выделить объявление  цветом">Выделить цветом</span>';
                                    } else {
                                        echo '<span onclick="changeStatus(' . $item['id'] . ')" id="status-btn-' . $item['id'] . '" class="btn-u btn-u-xs  btn-u-red" title="Изменить статус на - Видно всем">Видно только мне</span>';
                                    }

                                    echo Html::a('Редактировать',['/realty/sale/update', 'id' => $item['id']], ['class'=>'btn-u btn-u-xs  btn-u-default'])

                                    ?>
                                </div>
                            </li>
                        </ul>
                        <ul class="list-inline up-ul">
                            <li>Цена: <strong><?= $item['cost'] != null ? number_format($item['cost'],2,',',"'").' руб.' : ' - не указана' ?></strong> ‎</li>
                            <li>
                                <i class="small-text">‎Дата объявления:</i>&nbsp;
                                <?= Yii::$app->formatter->asDate($item['created_at'], 'long') ?>
                            </li>
                            <li>
                            <span>
                                <i class="small-text">‎Поднято на верх:</i>&nbsp;
                                <span id="span_updated_at_<?=$item['id']?>"><?= $item['updated_at'] != $item['created_at'] ? Yii::$app->formatter->asDate($item['updated_at'], 'long') : 'Объявление еще не поднимали' ?></span>
                            ‎</li>
                            <li>
                                <i class="small-text">Выделено:</i>&nbsp;
                                <span id="span_vip_date_<?=$item['id']?>"><?= $item['vip_date'] != null ? Yii::$app->formatter->asDate($item['vip_date'], 'long') : 'Объявление еще не выделяли' ?></span>
                            ‎</li>
                        </ul>
                    </div>
                    <hr>
                <?php } ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
$this->registerJsFile('/js/date.format.js', ['depends' => [\yii\web\YiiAsset::className()]]);
$this->registerJsFile('/js/ajax/realty-sale.js', ['depends' => [\yii\web\YiiAsset::className()]]);
?>