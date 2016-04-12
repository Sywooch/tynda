<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\firm\FirmCat */

$this->title = 'Create Firm Cat';
$this->params['breadcrumbs'][] = ['label' => 'Firm Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="firm-cat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
