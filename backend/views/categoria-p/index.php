<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use dosamigos\datepicker\DatePicker;
use backend\models\Situation;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use backend\models\Product;
use backend\models\Shop;
use kartik\export\ExportMenu;
use yii\helpers\Url;

use kartik\select2\Select2;
use backend\models\Feriado;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategoriaPSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categorias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-p-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::button(Yii::t('app', 'Crear Categoría'), ['value' => 'index.php?r=categoria-p/create', 'class' => 'modalButtonCreate']) ?>
        <?= Html::a(Yii::t('app', 'Generar reporte'), ['report'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    $columns = [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            [
                'attribute' => 'estado',
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=>ArrayHelper::map([['id' => 0, 'nombre' => 'Activo'],['id' => 1, 'nombre' => 'Inactivo'] ], 'id', 'nombre'),
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                    'filterInputOptions'=>['placeholder'=>'Select situation'],
                'value' => function ($model) {   // here use($month)
                    if($model->estado == 0){
                        return "Activo";
                    }else{
                        return "Inactivo";
                    }
                    },                    
            ],

        ];


            echo ExportMenu::widget([
                'dataProvider' => $dataProvider,
                'columns' => $columns,
                'exportConfig' => [
                    ExportMenu::FORMAT_TEXT => false,
                    ExportMenu::FORMAT_HTML => false,
                    ExportMenu::FORMAT_EXCEL_X => false,
//                    ExportMenu::FORMAT_EXCEL => false
                ],
                'filename' => 'Reporte_'.date('d-m-Y'),
            ]);

            $columns = [
            ['class' => 'yii\grid\SerialColumn'],

            'nombre',
            [
                'attribute' => 'estado',
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=>ArrayHelper::map([['id' => 0, 'nombre' => 'Activo'],['id' => 1, 'nombre' => 'Inactivo'] ], 'id', 'nombre'),
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                    'filterInputOptions'=>['placeholder'=>'Select situation'],
                'value' => function ($model) {   // here use($month)
                    if($model->estado == 0){
                        return "Activo";
                    }else{
                        return "Inactivo";
                    }
                    },                    
            ],
                ['class' => 'yii\grid\ActionColumn',
                    'template' => '{view}{update}{delete}',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => Url::to('index.php?r=categoria-p%2Fview&id='.$model->id), 'class' => 'modalButtonView'], [
                                'title' => Yii::t('app', 'View'),
                            ]);
                        },

                        'update' => function ($url, $model) {
                            return Html::button('<span class="glyphicon glyphicon-pencil"></span>', ['value' => Url::to('index.php?r=categoria-p%2Fupdate&id='.$model->id), 'class' => 'modalButtonEdit'], [
                                'title' => Yii::t('app', 'Update'),
                            ]);
                        },

                        'delete' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 'index.php?r=categoria-p/delete&id='.$model->id, [
                                'data-method' => 'POST',
                                'title' => Yii::t('app', 'Update'),
                                'data-confirm' => "¿Está seguro que desea eliminar esta categoría?",
                                'role' => 'button',
                                'class' => 'modalButtonDelete',
                            ]);
                        }
                    ],
                ],
        ];
        ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' =>  $columns,
    ]); ?>
</div>
