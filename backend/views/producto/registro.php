<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Productos por categoria registrados');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="producto-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="container">
    <?php
    if ($unico == 1) {
        ?>
        <div class="row">
            <div class="col-lg-12">
                <?php
                $form = ActiveForm::begin();
                $model = \backend\models\Producto::find()->andFilterWhere(['=', 'category_id', 12])->one();
                echo "<h1>Elige la categoría a mostrar</h1>";
                echo "<div class='col-sm-6'>" . $form->field($model, 'category_id')->widget(\kartik\select2\Select2::classname(), [
                            'data' => \yii\helpers\ArrayHelper::map(\backend\models\CategoriaP::find()->all(), 'id', 'nombre'),
                            'options' =>
                                ['prompt' => 'Categoría',

                                    'onchange' => '
                        $.post("index.php?r=producto/registro-unico-ch&cat="' . '+$(this).val(), function( data ){
                            $("#1").html(data);
                        });
                    ',
                                ]
                        ]
                    );

                ?>
            </div>
        </div>
        <?php
    }
    ?>

<div class="row">
    <div class="col-sm-12">
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

        <div id="1">
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
    </div>
</div>

</div>