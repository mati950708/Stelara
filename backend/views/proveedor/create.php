<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Proveedor */

$this->title = Yii::t('app', 'Crear Proveedor');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Proveedors'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proveedor-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
