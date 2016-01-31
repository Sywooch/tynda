<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\jobs\BackJobResumeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Resumes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-resume-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Job Resume', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_user',
            'status',
            'top',
            'vip',
            // 'title',
            // 'description',
            // 'salary',
            // 'employment',
            // 'created_at',
            // 'updated_at',
            // 'm_keyword',
            // 'm_description',
            // 'top_date',
            // 'vip_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
