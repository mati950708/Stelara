<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\RegistroSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registro-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'cantidad') ?>

    <?= $form->field($model, 'fecha') ?>

    <?= $form->field($model, 'estado') ?>

    <?= $form->field($model, 'observaciones') ?>

    <?php // echo $form->field($model, 'producto_id') ?>

    <?php // echo $form->field($model, 'tipo_r_id') ?>

    <?php // echo $form->field($model, 'cliente_id') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
