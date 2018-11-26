<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use backend\models\Situation;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Product;
use backend\models\Shop;
use kartik\export\ExportMenu;
use kartik\select2\Select2;
use backend\models\Feriado;



/* @var $this yii\web\View */
/* @var $searchModel backend\models\RegistroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Registros');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="registro-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button(Yii::t('app', 'Crear Registro'), ['value' => 'index.php?r=registro/create', 'class' => 'modalButtonCreate']) ?>
        <?= Html::a(Yii::t('app', 'Generar reporte de ganancias'), ['report'], ['class' => 'btn btn-info']) ?>
    </p>

    <?php echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'cantidad',
        [
            'attribute' => 'fecha',
            'value' => 'fecha',
            'format' => ['date', 'php:Y/m/d'],
            'filter' => \dosamigos\datepicker\DatePicker::widget([
                'model' => $searchModel,
                'attribute' => 'fecha',
                'clientOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy/mm/dd'
                ]
            ])
        ],
        [
            'attribute'=>'producto_id',
            'value'=>'producto.nombre',
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(backend\models\Producto::find()->orderBy('nombre')->all(), 'id', 'nombre'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Elige el producto'],
        ],
        [
            'attribute'=>'tipo_r_id',
            'value'=>'tipoR.nombre',
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(backend\models\TipoR::find()->orderBy('nombre')->all(), 'id', 'nombre'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Elige el tipo de registro'],
        ],
        [
            'attribute'=>'cliente_id',
            'value'=>'cliente.nombre',
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>ArrayHelper::map(backend\models\Cliente::find()->orderBy('nombre')->all(), 'id', 'nombre'),
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true],
            ],
            'filterInputOptions'=>['placeholder'=>'Elige el cliente'],
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

            'cantidad',
            [
                'attribute' => 'fecha',
                'value' => 'fecha',
                'format' => ['date', 'php:Y/m/d'],
                'filter' => \dosamigos\datepicker\DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'fecha',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy/mm/dd'
                    ]
                ])
            ],
            [
                'attribute'=>'producto_id',
                'value'=>'producto.nombre',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(backend\models\Producto::find()->andFilterWhere(['=', 'estado', '0'])->orderBy('nombre')->all(), 'id', 'nombre'),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Elige el producto'],
            ],
            [
                'attribute'=>'tipo_r_id',
                'value'=>'tipoR.nombre',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(backend\models\TipoR::find()->orderBy('nombre')->all(), 'id', 'nombre'),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Elige el tipo de registro'],
            ],
            [
                'attribute'=>'cliente_id',
                'value'=>'cliente.nombre',
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(backend\models\Cliente::find()->andFilterWhere(['=', 'estado', '0'])->andFilterWhere(['=', 'estado', '0'])->orderBy('nombre')->all(), 'id', 'nombre'),
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Elige el cliente'],
            ],

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => Url::to('index.php?r=registro%2Fview&id='.$model->id), 'class' => 'modalButtonView'], [
                            'title' => Yii::t('app', 'View'),
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
