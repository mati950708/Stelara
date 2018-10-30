<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Registro */

$this->title = Yii::t('app', 'Update Registro: ' .
$this->title = $model->fecha." producto: ".$model->producto->nombre, [
    'nameAttribute' => '' .
$this->title = $model->fecha." producto: ".$model->producto->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Registros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>
$this->title = $model->fecha." producto: ".$model->producto->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="registro-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
