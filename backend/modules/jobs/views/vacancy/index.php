<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\jobs\BackJobVacancySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Job Vacancies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="job-vacancy-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Job Vacancy', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_user',
            'status',
            'top_date',
            'vip_date',
            // 'title',
            // 'description:ntext',
            // 'employment',
            // 'salary',
            // 'education',
            // 'address',
            // 'duties:ntext',
            // 'require:ntext',
            // 'conditions:ntext',
            // 'created_at',
            // 'updated_at',
            // 'm_keyword',
            // 'm_description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
