<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Bitacora */

$this->title = Yii::t('app', 'Create Bitacora');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bitacoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bitacora-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
