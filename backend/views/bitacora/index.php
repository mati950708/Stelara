<?php

use yii\helpers\Html;
use yii\grid\GridView;
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
/* @var $searchModel backend\models\BitacoraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Bitacora');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bitacora-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'fecha',
                'value' => 'fecha',
                'format' => ['date', 'php:Y/m/d'],
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'fecha',
                    'clientOptions' => [
                        'autoclose' => true,
                        'format' => 'yyyy/mm/dd'
                    ]
                ])
            ],
            'descripcion:ntext',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['value' => Url::to('index.php?r=bitacora%2Fview&id='.$model->id), 'class' => 'modalButtonView'], [
                            'title' => Yii::t('app', 'View'),
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
