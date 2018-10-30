<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Bitacora */

$this->title = $model->fecha;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Bitacoras'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bitacora-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'fecha',
            'descripcion:ntext',
            'producto',
        ],
    ]) ?>

</div>
