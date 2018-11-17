<?php

namespace backend\controllers;

use backend\models\Bitacora;
use backend\models\Registro;
use Yii;
use backend\models\Producto;
use backend\models\ProductoSearch;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductoController implements the CRUD actions for Producto model.
 */
class ProductoController extends Controller
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
     * Lists all Producto models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity) {
            $userE = Yii::$app->db2->createCommand("SELECT dblink_user_exist(" . Yii::$app->user->identity->getId() . ");")->queryAll()[0]['dblink_user_exist'];
            if ($userE == 0){
                Yii::$app->user->logout();
                return $this->redirect(['site/login']);
            }
        }else{
            return $this->redirect(['site/login']);
        }
        $searchModel = new ProductoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['=', 'estado', '0'])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionRegistro()
    {

        $crosstab = Yii::$app->db2->createCommand("
SELECT *
FROM crosstab(
    'SELECT c.nombre AS cnombre, p.precio_unit, p.nombre
     FROM producto p
     INNER JOIN categoria_p c
     ON c.id = p.category_id
     AND p.estado = 0'
) AS ct(Categoria character varying(45), Primer_Producto character varying(45), Segundo_Producto character varying(45), Tercer_Producto character varying(45));
")->queryAll();

        $dataProvider = new ArrayDataProvider([

            'allModels' => $crosstab,

            'sort' => [

                'attributes' => [
                    'categoria',
                    'primer_producto',
                    'segundo_producto',
                    'tercer_producto'
                ],

            ],

            'pagination' => [

                'pageSize' => 12,

            ],

        ]);

        return $this->render('registro', [
            'dataProvider' => $dataProvider,
            'unico' => 0,
        ]);
    }

    public function actionRegistroUnico(){

        $crosstab = Yii::$app->db2->createCommand("
select cursor();
")->queryAll();

        $array = [];
        foreach($crosstab AS $cros){
//            print_r($cros);
            //          echo "<br><br>";
            foreach($cros AS $cro){
                //            print_r($cro);
                //          echo "<br><br>";
                $string = str_replace('(', '', $cro);
                $string = str_replace(')', '', $string);
                $string = str_replace('"', '', $string);
                //        echo $string;
                //      echo "<br><br>";
                $array = explode(',', $string);
                //    print_r($array);
                //  echo "<br><br>";
                $array = [ 0 => [
                    'categoria' => $array[0],
                    'primer_producto' => $array[1],
                    'segundo_producto' => $array[2],
                    'tercer_producto' => $array[3],
                ]];
                //print_r($array);

            }
        }

        $dataProvider = new ArrayDataProvider([

            'allModels' => $array,

            'sort' => [
                'attributes' => [
                    'categoria',
                    'primer_producto',
                    'segundo_producto',
                    'tercer_producto'
                ],

            ],

            'pagination' => [

                'pageSize' => 12,

            ],

        ]);

        return $this->render('registro', [
            'dataProvider' => $dataProvider,
            'unico' => 1,
        ]);
    }
    public function actionRegistroUnicoCh($cat){

        $crosstab = Yii::$app->db2->createCommand("
select cursorch(".$cat.");
")->queryAll();

        $array = [];
        foreach($crosstab AS $cros){
            foreach($cros AS $cro){
                $string = str_replace('(', '', $cro);
                $string = str_replace(')', '', $string);
                $string = str_replace('"', '', $string);
                $array = explode(',', $string);
                $array = [ 0 => [
                    'categoria' => $array[0],
                    'primer_producto' => $array[1],
                    'segundo_producto' => $array[2],
                    'tercer_producto' => $array[3],
                ]];
            }
        }

        $dataProvider = new ArrayDataProvider([

            'allModels' => $array,

            'sort' => [
                'attributes' => [
                    'categoria',
                    'primer_producto',
                    'segundo_producto',
                    'tercer_producto'
                ],

            ],

            'pagination' => [

                'pageSize' => 12,

            ],

        ]);

        echo  GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' =>  [
                'categoria',
                'primer_producto',
                'segundo_producto',
                'tercer_producto'
            ],
        ]);
    }

    /**
     * Displays a single Producto model.
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
     * Creates a new Producto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Producto();

        if ($model->load(Yii::$app->request->post())) {
            $model->id = Yii::$app->db2->createCommand("SELECT nextval('producto_id_seq');")->queryAll()[0]['nextval'];
            $model->estado = 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Producto ".$model->nombre.", guardado.");
            }else{
                Yii::$app->session->setFlash('danger', "Producto ".$model->nombre.", NO SE PUDO guardar.");
                echo "<script>window.history.back();</script>";
                die;
            }

            $reg = new Registro();
            $reg->id = Yii::$app->db2->createCommand("SELECT nextval('registro_id_seq');")->queryAll()[0]['nextval'];
            $reg->cantidad = $model->cantidad_actual;
            $reg->fecha = date('Y-m-d');
            $reg->estado = 0;
            $reg->producto_id = $model->id;
            $reg->tipo_r_id = 1;
            $reg->cliente_id = 1;
            $reg->precio_venta = $model->precio_unit;
            $reg->precio_costo = $model->costo_unit;
            if(!$reg->save()){
                print_r($reg->getErrors());
                die;
            };

            $bit = new Bitacora();
            $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
            $bit->fecha = date('Y-m-d');
            $bit->descripcion = 'Insertar Producto: '.$model->nombre.', Y su primer registro.';
            if(!$bit->save()){
                print_r($bit->getErrors());
                die;
            };


                echo "<script>window.history.back();</script>";
                die;
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Producto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                Yii::$app->session->setFlash('warning', "Producto ".$model->nombre.", actualizado.");
            }else{
                Yii::$app->session->setFlash('danger', "Producto ".$model->nombre.", NO SE PUDO actualizar.");
                echo "<script>window.history.back();</script>";
                die;
            }

            $bit = new Bitacora();
            $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
            $bit->fecha = date('Y-m-d');
            $bit->descripcion = 'Actualizar Producto: '.$model->nombre.'.';
            if(!$bit->save()){
                print_r($bit->getErrors());
                die;
            };

            echo "<script>window.history.back();</script>";
            die;
        }

        return $this->renderAjax('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Producto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //$this->findModel($id)->delete();
        $model = $this->findModel($id);
        $model->estado = 1;

        if ($model->save()) {
            Yii::$app->session->setFlash('danger', "Producto ".$model->nombre.", eliminada.");
        }else{
            Yii::$app->session->setFlash('info', "Producto ".$model->nombre.", NO SE PUDO eliminar.");
            echo "<script>window.history.back();</script>";
            die;
        }

        $bit = new Bitacora();
        $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
        $bit->fecha = date('Y-m-d');
        $bit->descripcion = 'Eliminar Producto: '.$model->nombre.'.';
        if(!$bit->save()){
            print_r($bit->getErrors());
            die;
        };

        echo "<script>window.history.back();</script>";
    }

    /**
     * Finds the Producto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Producto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Producto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
