<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaP */

$this->title = Yii::t('app', 'Actualizar Categoria: ' . $model->nombre, [
    'nameAttribute' => '' . $model->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoria Ps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="categoria-p-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
