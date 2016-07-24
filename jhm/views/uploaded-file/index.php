<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UploadedFileSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Uploaded Files';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="uploaded-file-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Uploaded File', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'added_by',
            'candidate_first_name',
            'candidate_last_name',
            'file_name',
            // 'path',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
