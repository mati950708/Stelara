<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Proveedor */

$this->title = Yii::t('app', 'Actualizar Proveedor: ' . $model->nombre, [
    'nameAttribute' => '' . $model->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Proveedors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="proveedor-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
