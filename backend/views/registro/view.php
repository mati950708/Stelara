<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Registro */

$this->title = $model->fecha." producto: ".$model->producto->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cantidad',
            'fecha',
            [
                'attribute' => 'producto_id',
                'value' => $model->producto->nombre,
            ],
            [
                'attribute' => 'tipo_r_id',
                'value' => $model->tipoR->nombre,
            ],
            [
                'attribute' => 'tipo_r_id',
                'value' => $model->cliente->nombre,
            ],
            'observaciones:ntext',
        ],
    ]) ?>

</div>
