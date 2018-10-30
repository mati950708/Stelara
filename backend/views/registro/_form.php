<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use dosamigos\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\Registro */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="registro-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-lg-6">
            <?= $form->field($model, 'cantidad')->Input('number') ?>
        </div>
        <div class="col-lg-6">
            <?= $form->field($model, 'fecha')->widget(
                DatePicker::className(), [
                // inline too, not bad
                'language' => 'en_EN',
                'value' => 'yyyy/mm/dd',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy/mm/dd'
                ]
            ])?>
        </div>
    </div>
    <div class="row">
            <div class="col-lg-4">
                <?= $form->field($model, 'tipo_r_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\TipoR::find()->all(), 'id', 'nombre'),
                    [
                        'prompt' => 'Elige el tipo de registro'
                    ]
                ) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'producto_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\Producto::find()->all(), 'id', 'nombre'),
                    [
                        'prompt' => 'Elige el producto'
                    ]
                ) ?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, 'cliente_id')->dropDownList(
                    \yii\helpers\ArrayHelper::map(\backend\models\Cliente::find()->all(), 'id', 'nombre'),
                    [
                        'prompt' => 'Elige el cliente'
                    ]
                ) ?>
            </div>
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
