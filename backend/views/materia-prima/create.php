<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MateriaPrima */

$this->title = Yii::t('app', 'Crear Materia Prima');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Materia Primas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materia-prima-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
