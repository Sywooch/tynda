<?php

use yii\helpers\Html;
use app\modules\afisha\Module;


/* @var $this yii\web\View */
/* @var $model common\models\Afisha */

$this->title = 'Создать статью';
$this->params['breadcrumbs'][] = ['label' => 'Статьи', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <?= $this->render('_form', [
        'model' => $model,
        'module' => $module,
    ]) ?>

</div>
