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
    <h1 align="center">Reporte de Registros de ganancias</h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]);
            $columns = [
                'Nombre',
                'Entrada',
                'Salida',
                'Merma',
                'Venta',
                'Costo',
                'Ganancia',
        ];
            $columns2 = [
                    'Nombre',
                'CantidadRestante',
                'CantidadRestanteEstimadoEnVentas',
                'GananciasTotalesEstimado',
            ]
        ?>

    <hr class="btn-info">
    <h2>
        Ganancias actuales:
    </h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' =>  $columns,
    ]); ?>
    <h3>Total: <b><?php
            if ($ganancias>0){
                echo "<b style='color: green;'>$$ganancias</b>";
            }else{
                echo "<b style='color: red;'>$$ganancias</b>";
            }
            ?></b></h3>

    <hr class="btn-success">
    <h2>
        Ganancias posibles:
    </h2>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' =>  $columns2,
    ]); ?>
    <h3>Total: <b><?php
            if ($gananciasT>0){
                echo "<b style='color: green;'>$$gananciasT</b>";
            }else{
                echo "<b style='color: red;'>$$gananciasT</b>";
            }
            ?></b></h3>
</div>
