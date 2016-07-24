<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UploadedFile */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="uploaded-file-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'candidate_first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'candidate_last_name')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'file')->fileInput() ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
