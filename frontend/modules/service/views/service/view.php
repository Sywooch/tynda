<?php
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\widgets\Avatar;
use common\widgets\Arrays;

/* @var $this yii\web\View */
/* @var $model common\models\goods\Goods */

if (!empty($model['m_description'])) {
    $this->registerMetaTag(['content' => Html::encode($model['m_description']), 'name' => 'description']);
}
if (!empty($model['m_keyword'])) {
    $this->registerMetaTag(['content' => Html::encode($model['m_keyword']), 'name' => 'keywords']);
}
$this->params['left'] = true;
$this->params['right'] = true;
$this->title = $model['name'];
$this->params['breadcrumbs'][] = ['label' => 'Услуги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$user = Yii::$app->user->getIdentity();
?>
<div class="goods-view">
    <div class="form-group">
        <?= Html::a('<i class="fa fa-reply"></i>&nbsp;&nbsp;Назад к списку услуг', [Url::to('/service/service/index')], ['class' => 'btn btn-default',]) ?>
        <?php if ($user->id === $model['id_user']) { ?>
            <?= Html::a('<i class="fa fa-edit"></i>&nbsp;&nbsp;Редактировать это объявление', [Url::to('/service/service/update'), 'id' => $model['id']], ['class' => 'btn btn-primary']) ?>
        <?php } ?>
        <?= Html::a('<i class="fa fa-plus"></i>&nbsp;&nbsp;Подать объявление', [Url::to('/service/service/create')], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="row">
        <div class="col-sm-3 side_left">
            <div class="thumbnail" style="padding: 2px;"><?= Avatar::imgService($model['main_img'], '100%') ?></div>
        </div>
        <div class="col-sm-9">
            <?php if ($model['company']) { ?>
                <h4><i class="small-text" style="font-size: 0.7em;">Продавец:</i><strong style="font-size: 0.9em; font-style: italic;"><?= $model['username'] ?></strong></h4>
                <h4><i class="small-text" style="font-size: 0.7em;">Контактное лицо:</i><strong style="font-size: 0.9em; font-style: italic;"><?= $model['fio'] ?></strong></h4>
            <?php } else { ?>
                <h4><i class="small-text" style="font-size: 0.7em;">Продавец:</i><strong style="font-size: 0.9em; font-style: italic;"><?= $model['fio'] ?></strong></h4>
            <?php } ?>
            <p style="margin: 2px;"><i class="small-text">Тел:</i> <strong><?= $model['tel'] == '' ? ' - не указан': $model['tel'] ?></strong></p>

            <p style="margin: 2px;"><i class="small-text">E-mail:</i> <strong><?= $model['email'] ?></strong></p>
        </div>
    </div>
    <hr style="margin: 0px; border: 2px solid #ddd;">
    <div class="row">
        <div class="col-sm-1">
            <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #909090;">Услуга: </p>
        </div>
        <div class="col-sm-11">
            <p style="margin-bottom: 0px; margin-top: 8px; font-size: 1.2em; color: #555;"><i class="small-text">Цена: </i>&nbsp;<span style="font-weight: bold;"><?= $model['cost'] !='' ? number_format($model['cost'],2,',',"'"). '&nbsp;<i class="small-text">Руб. </i>' : ' - не указана' ?></span></p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <h1><strong style="font-size: 0.9em; font-style: italic;"><?= $model['name'] ?></strong></h1>
            <h4 style="margin: 2px;"><i class="small-text" style="font-size: 0.7em;">Категория:</i><?= Html::a(Html::encode($model['category']), [Url::to('/service/service/index'), 'cat' => $model['alias']], ['class' => '']) ?></h4>

            <p><i class="small-text">Описание:</i> <?= $model['description'] != '' ? nl2br($model['description']) : ' - отсутствует' ?></p>
        </div>
    </div>


</div>
