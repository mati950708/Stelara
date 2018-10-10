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

?>
<div class="categoria-p-index">
<h1 align="center"><img src="http://www.itses.edu.mx/img/logo2.png" alt=""></h1>
    <h1 align="center">Reporte de Categorias</h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);
            $columns = [

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
        ?>



    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' =>  $columns,
    ]); ?>
</div>
