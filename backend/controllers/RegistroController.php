<?php

namespace backend\controllers;

use Yii;
use backend\models\Registro;
use backend\models\RegistroSearch;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Bitacora;
use backend\models\Producto;

use kartik\mpdf\Pdf;
/**
 * RegistroController implements the CRUD actions for Registro model.
 */
class RegistroController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Registro models.
     * @return mixed
     */
    public function actionIndex()
    {


        $searchModel = new RegistroSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Registro model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Registro model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Registro();

        if ($model->load(Yii::$app->request->post())) {

            $model->observaciones = rtrim(ltrim($model->observaciones));

            $model->id = Yii::$app->db2->createCommand("SELECT nextval('registro_id_seq');")->queryAll()[0]['nextval'];
            $model->estado = 0;

            $producto = Producto::find()->where(['id' => $model->producto_id])->one();
            $model->precio_venta = $producto->precio_unit;
            $model->precio_costo= $producto->costo_unit;


            if($model->tipo_r_id == 1){
                $producto->cantidad_actual = $producto->cantidad_actual + $model->cantidad;
            }else{
                $producto->cantidad_actual = $producto->cantidad_actual - $model->cantidad;
            }

            if ($producto->cantidad_actual < 0){
                Yii::$app->session->setFlash('danger', "Producto: ".$model->producto->nombre.", NO tiene suficientes UNIDADES para esa transacción.");
                echo "<script>window.history.back();</script>";
                die;
            }
                $bit = new Bitacora();
                $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
                $bit->fecha = date('Y-m-d');
                $bit->descripcion = 'Insertar Registro: ' . $model->fecha . ' Producto: ' . $producto->nombre . '.';


            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Registro de ".$model->producto->nombre.", guardado.");
            }else{
                Yii::$app->session->setFlash('danger', "Registro de ".$model->producto->nombre.", NO SE PUDO guardar.");
                echo "<script>window.history.back();</script>";
                die;
            }
                if ($model->save()) {
                    if (!$bit->save()) {
                        print_r($bit->getErrors());
                        die;
                    };
                    $producto->save();
                    echo "<script>window.history.back();</script>";
                    die;
                }

        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Registro model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $models = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->observaciones = rtrim(ltrim($model->observaciones));

            if ($model->save()) {
                Yii::$app->session->setFlash('warning', "Registro de ".$model->producto->nombre.", actualizado.");
            }else{
                Yii::$app->session->setFlash('danger', "Registro de ".$model->producto->nombre.", NO SE PUDO actualizar.");
                echo "<script>window.history.back();</script>";
                die;
            }

            $extra = $models->cantidad - $model->cantidad;

            $producto = $model->producto;
            $productoAnterior = 0;


            if ($model->producto_id == $models->producto_id) {
                if ($model->tipo_r_id != $models->tipo_r_id) {
                    if ($model->tipo_r_id == 1) {
                        $producto->cantidad_actual = $producto->cantidad_actual + $models->cantidad + $model->cantidad;
                    } else if ($models->tipo_r_id == 1) {
                        $producto->cantidad_actual = $producto->cantidad_actual - $models->cantidad - $model->cantidad;
                    }
                } else {
                    if ($model->tipo_r_id == 1) {
                        $producto->cantidad_actual = $producto->cantidad_actual - $extra;
                    } else {
                        $producto->cantidad_actual = $producto->cantidad_actual + $extra;
                    }
                }
            }else{
                $productoAnterior = $models->producto;

                if ($models->tipo_r_id == 1) {
                    $productoAnterior->cantidad_actual = $productoAnterior->cantidad_actual - $models->cantidad;
                    $producto->cantidad_actual = $producto->cantidad_actual + $model->cantidad;
                } else {
                    $productoAnterior->cantidad_actual = $productoAnterior->cantidad_actual + $models->cantidad;
                    $producto->cantidad_actual = $producto->cantidad_actual - $model->cantidad;
                }
            }


            $bit = new Bitacora();
            $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
            $bit->fecha = date('Y-m-d');
            $bit->descripcion = 'Editar Registro: '.$model->fecha.' Producto: '.$producto->nombre.'.';

            if(!$bit->save()){
                print_r($bit->getErrors());
                die;
            };

            if(!$producto->save()){
                print_r($producto->getErrors());
                die;
            };

            if ($productoAnterior != 0){
                if(!$productoAnterior->save()){
                    print_r($productoAnterior->getErrors());
                    die;
                };
            }


                echo "<script>window.history.back();</script>";
                die;
        }


        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Registro model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Registro model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Registro the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Registro::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionReport() {

        \yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        //\yii::$app->response->headers->add('Content-Type', 'application/pdf');

        // get your HTML raw content without any layouts or scripts
        $searchModel = new RegistroSearch();
        $data = $searchModel->search(Yii::$app->request->queryParams);
        $productos = Producto::find()->all();
        $res = [];
        foreach ($productos AS $producto){
            $dataps = Yii::$app->db2->createCommand("SELECT * FROM registro WHERE producto_id = $producto->id;")->queryAll();
            $entradag = [];
            $salidag= [];
            $mermag = [];
            unset($entradag[0]);
            unset($salidag[0]);
            unset($mermag[0]);
            $venta = 0;
            $costo = 0;
     //       echo "<h1>$producto->nombre</h1>";
            foreach ($dataps AS $datap) {
                switch ($datap['tipo_r_id']){
                    case 1:
                        if(array_key_exists("entrada_" . $datap['precio_venta'], $mermag)) {
                            $entradag["entrada_" . $datap['precio_costo']]['cantidad'] = $entradag["entrada_" . $datap['precio_costo']]['cantidad'] + $datap['cantidad'];
                        }else{
                            $entradag["entrada_" . $datap['precio_costo']] = ['precio' => $datap['precio_costo'], 'cantidad' => $datap['cantidad']];
                        }
                        break;
                    case 2:
                        if(array_key_exists("salida_" . $datap['precio_venta'], $salidag)){
                            $salidag["salida_" . $datap['precio_venta']]['cantidad'] = $salidag["salida_" . $datap['precio_venta']]['cantidad'] + $datap['cantidad'];
                        }else{
                            $salidag["salida_" . $datap['precio_venta']] = ['precio' => $datap['precio_venta'], 'cantidad' => $datap['cantidad']];
                        }
                        break;
                    case 3:
                        if(array_key_exists("merma_" . ($datap['precio_venta'] - $datap['precio_costo']), $mermag)) {
                            $mermag["merma_" . ($datap['precio_venta'] - $datap['precio_costo'])]['cantidad'] = $mermag["merma_" . ($datap['precio_venta'] - $datap['precio_costo'])]['cantidad'] + $datap['cantidad'];
                        }else{
                            $mermag["merma_" . ($datap['precio_venta'] - $datap['precio_costo'])] = ['precio' => ($datap['precio_venta'] - $datap['precio_costo']), 'cantidad' => $datap['cantidad']];
                        }
                        break;
                }
            }
    /*        print_r($entradag);
            echo "<br><br>";
            print_r($salidag);
            echo "<br><br>";
            echo print_r($mermag);
            echo "<br><br>Entrada: ";
  */          $entrada = 0;
            $salida = 0;
            $merma = 0;

            foreach ($entradag AS $entr){
                $entrada = $entrada + ($entr['precio'] * $entr['cantidad']);
            }
            foreach ($salidag AS $sal){
                $salida = $salida + ($sal['precio']*$sal['cantidad']);
            }
            foreach ($mermag AS $mer){
                $merma = $merma + ($mer['precio']*$mer['cantidad']);
            }
/*
            echo $entrada."<br><br>Salida: ";
            echo $salida."<br><br>Merma: ";
            echo $merma."<br><br>Venta: ";
            echo $venta = $salida;
            echo "<br><br>Costo: ";
            echo $costo = ($entrada+$merma);
            echo "<br><br>Ganancia: ";
            echo $ganancia = $venta-$costo;
            echo "<br><br>Cantidad restante: ";
            echo $producto->cantidad_actual;
            echo "<br><br>Cantidad restante estimado en ventas: ";
            echo $ventasR = $producto->cantidad_actual*$producto->precio_unit;
            echo "<br><br>Ganancia total estimada cuando se venda: ";
            echo $gananciaT = $ganancia + $ventasR;
            echo "<br><br><hr class='btn-success'>";*/
            $venta = $salida;
            $costo = ($entrada+$merma);
            $ganancia = $venta-$costo;
            $producto->cantidad_actual;
            $ventasR = $producto->cantidad_actual*$producto->precio_unit;
            $gananciaT = $ganancia + $ventasR;


            $res[] = [
                'Nombre' => $producto->nombre,
                'Entrada' => $entrada,
                'Salida' => $salida,
                'Merma' => $merma,
                'Venta' => $venta,
                'Costo' => $costo,
                'Ganancia' => $ganancia,
                'CantidadRestante' => $producto->cantidad_actual,
                "CantidadRestanteEstimadoEnVentas" => $ventasR,
                "GananciasTotalesEstimado" => $gananciaT
            ];

        }
//            print_r($res);
       // echo "<br><br>Ganancias Completas: ";

        $gananciasC = 0;
        $gananciasTC = 0;
        foreach ($res AS $re){
            $gananciasC = $gananciasC + $re['Ganancia'];
            $gananciasTC = $gananciasTC + $re['GananciasTotalesEstimado'];
        }
//        echo $gananciasC."<br><br>Ganancias Completas Estimadas: ";
  //      echo $gananciasTC;
        $dataProvider = new ArrayDataProvider([

            'allModels' => $res,

            'sort' => [
                'attributes' => [
                    'Nombre',
                    'Entrada',
                    'Salida',
                    'Merma',
                    'Venta',
                    'Costo',
                    'Ganancia',
                    'CantidadRestante',
                    'CantidadRestanteEstimadoEnVentas',
                    'GananciasTotalesEstimado',
                ],

            ],

            'pagination' => [

                'pageSize' => 100,

            ],

        ]);

        $content = $this->renderPartial('report', [
            'dataProvider' => $dataProvider,
            'res' => $res,
            'ganancias' => $gananciasC,
            'gananciasT' => $gananciasTC
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf();
        $pdf->content = $content;
        $pdf->methods = [
            'SetHeader'=>['Reporte de Ganancias'],
            'SetFooter'=>['{PAGENO}'],
        ];
        $pdf->options = ['title' => 'Reporte Registro ganancias'];

        /* setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_BLANK,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            // your html content input
            'content' => $content,
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Report Categoría'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader'=>['Krajee Report Header'],
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
*/
        // return the pdf output as per the destination setting
        return $pdf->render();
    }
}
