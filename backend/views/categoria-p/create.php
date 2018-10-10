<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaP */

$this->title = Yii::t('app', 'Crear Categoria');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoria'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-p-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
