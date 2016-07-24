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
        <?= Html::a('Upload File', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
    'attribute'=>'file_content',
    'value'=> function($model){ return substr($model->file_content, 0, 15);
}
  ],
            
            ['attribute' =>'added_by',
            'value' => function($model){
                return \app\models\User::find()->where(['id' => $model->added_by])->one()['email'];
            }
            ],
            'candidate_first_name',
            'candidate_last_name',
            'file_name',
            // 'path',

            ['class' => 'yii\grid\ActionColumn'],

        ],
    ]); ?>
</div>
