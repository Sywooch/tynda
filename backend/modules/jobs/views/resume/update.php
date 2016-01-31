<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\jobs\JobResume */

$this->title = 'Update Job Resume: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Job Resumes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="job-resume-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
