<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UploadedFile */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="uploaded-file-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'added_by')->textInput() ?>

    <?= $form->field($model, 'candidate_first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'candidate_last_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
