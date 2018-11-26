<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MateriaPrimaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Materias Prima');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materia-prima-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button(Yii::t('app', 'Crear Materia prima'), ['value' => 'index.php?r=materia-prima/create', 'class' => 'modalButtonCreate']) ?>
    </p>

    <?php
    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'nombre',
            'descripcion:ntext',
            'observaciones:ntext',
            [
                'attribute'=>'proveedor_id',
                'value'=>'proveedor.nombre',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(backend\models\Proveedor::find()->orderBy('nombre')->all(), 'id', 'nombre'),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Elige el proveedor'],
            ],
            ],
        'exportConfig' => [
            ExportMenu::FORMAT_TEXT => false,
            ExportMenu::FORMAT_HTML => false,
            ExportMenu::FORMAT_EXCEL_X => false,
//                    ExportMenu::FORMAT_EXCEL => false
        ],
        'filename' => 'Reporte_'.date('d-m-Y'),
    ]);
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            'descripcion:ntext',
            [
                'attribute'=>'proveedor_id',
                'value'=>'proveedor.nombre',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(backend\models\Proveedor::find()->andFilterWhere(['=', 'estado', '0'])->orderBy('nombre')->all(), 'id', 'nombre'),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Elige el proveedor'],
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => Url::to('index.php?r=materia-prima%2Fview&id='.$model->id), 'class' => 'modalButtonView'], [
                            'title' => Yii::t('app', 'View'),
                        ]);
                    },

                    'update' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to('index.php?r=materia-prima%2Fupdate&id='.$model->id), 'class' => 'modalButtonEdit'], [
                            'title' => Yii::t('app', 'Update'),
                        ]);
                    },

                    'delete' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'index.php?r=materia-prima/delete&id='.$model->id, [
                            'data-method' => 'POST',
                            'title' => Yii::t('app', 'Update'),
                            'data-confirm' => "¿Está seguro que desea eliminar esta categoría?",
                            'role' => 'button',
                            'class' => 'modalButtonDelete',
                        ]);
                    }
                ],
            ],
        ],
    ]); ?>
</div>
