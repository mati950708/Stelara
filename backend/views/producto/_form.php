<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Producto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-4">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'precio_unit')->Input('numeric') ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($model, 'costo_unit')->Input('numeric') ?>
        </div>
    </div>
    <div class="row">
        <?php
        if ($model->isNewRecord) {
            ?>
            <div class="col-lg-6">
                <?= $form->field($model, 'cantidad_actual')->Input('number', ['min' => '1']) ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'category_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\CategoriaP::find()->all(), 'id', 'nombre'),
                    [
                        'prompt' => 'Elige la categoría'
                    ]
                ) ?>
            </div>
            <?php
        }else {
            ?>
            <div class="col-lg-12">
                <?= $form->field($model, 'category_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\CategoriaP::find()->all(), 'id', 'nombre'),
                    [
                        'prompt' => 'Elige la categoría'
                    ]
                ) ?>
            </div>
            <?php
        }
        ?>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <?= $form->field($model, 'observaciones')->textarea(['rows' => 6]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
