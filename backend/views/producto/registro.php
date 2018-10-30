<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Productos por categoria registrados');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button(Yii::t('app', 'Crear Producto'), ['value' => 'index.php?r=producto/create', 'class' => 'modalButtonCreate']) ?>
    </p>
    <?php

    echo ExportMenu::widget([
        'dataProvider' => $dataProvider,
        'columns' =>[
            'categoria',
            'primer_producto',
            'segundo_producto',
            'tercer_producto'
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
        'columns' =>  [
            'categoria',
            'primer_producto',
            'segundo_producto',
            'tercer_producto'
        ],
    ]); ?>

</div>
