<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaP */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="categoria-p-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?php
    if (!$model->isNewRecord) {
        ?>
        <?= $form->field($model, 'estado')->dropDownList(
            \yii\helpers\ArrayHelper::map([['id' => 0, 'nombre' => 'Activo'], ['id' => 1, 'nombre' => 'Inactivo']], 'id', 'nombre'),
            [
                'prompt' => 'Elige el estado',
                'required' => true
            ]
        ) ?>
        <?php
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
