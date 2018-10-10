<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoriaP */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Categoria'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-p-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'nombre',
            [
                'attribute' => 'estado',
                'value' => function ($model) {   // here use($month)
                    if($model->estado == 0){
                        return "Activo";
                    }else{
                        return "Inactivo";
                    }
                },
            ],
        ],
    ]) ?>

</div>
