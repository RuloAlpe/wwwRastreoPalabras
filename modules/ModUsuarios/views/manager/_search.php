<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SearchUsuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ent-usuarios-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_usuario') ?>

    <?= $form->field($model, 'txt_token') ?>

    <?= $form->field($model, 'txt_username') ?>

    <?= $form->field($model, 'txt_apellido_paterno') ?>

    <?= $form->field($model, 'txt_apellido_materno') ?>

    <?php // echo $form->field($model, 'txt_auth_key') ?>

    <?php // echo $form->field($model, 'txt_password_hash') ?>

    <?php // echo $form->field($model, 'txt_password_reset_token') ?>

    <?php // echo $form->field($model, 'txt_email') ?>

    <?php // echo $form->field($model, 'fch_creacion') ?>

    <?php // echo $form->field($model, 'fch_actualizacion') ?>

    <?php // echo $form->field($model, 'id_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
