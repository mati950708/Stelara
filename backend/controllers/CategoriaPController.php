<?php

namespace backend\controllers;

use Yii;
use backend\models\CategoriaP;
use backend\models\CategoriaPSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Bitacora;

/**
 * CategoriaPController implements the CRUD actions for CategoriaP model.
 */
class CategoriaPController extends Controller
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
     * Lists all CategoriaP models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoriaPSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['=', 'estado', '0'])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CategoriaP model.
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
     * Creates a new CategoriaP model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CategoriaP();

        if ($model->load(Yii::$app->request->post())) {

            $nombre = strtoupper($model->nombre);
            $cats = CategoriaP::find()->andFilterWhere(['=', 'estado', 0])->all();
            foreach ($cats AS $cat){
                if (trim(strtoupper($cat->nombre)) == trim($nombre)){
                    Yii::$app->session->setFlash('danger', "Cateogria: ".$model->nombre.", YA EXISTE.");
                    echo "<script>window.history.back();</script>";
                    die;
                }
            }
            $model->nombre = rtrim(ltrim($model->nombre));


            $model->id = Yii::$app->db2->createCommand("SELECT nextval('categoria_p_id_seq');")->queryAll()[0]['nextval'];
            $model->estado = 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Categoría ".$model->nombre.", guardada.");
            }else{
                Yii::$app->session->setFlash('danger', "Categoría ".$model->nombre.", NO SE PUDO guardar.");
                echo "<script>window.history.back();</script>";
                die;
            }

            $bit = new Bitacora();
            $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
            $bit->fecha = date('Y-m-d');
            $bit->descripcion = 'Insertar Categoría de producto: '.$model->nombre.'.';
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
     * Updates an existing CategoriaP model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $nombre = strtoupper($model->nombre);
            $cats = CategoriaP::find()->andFilterWhere(['=', 'estado', 0])->andFilterWhere(['!=', 'id', $model->id])->all();
            foreach ($cats AS $cat){
                if (trim(strtoupper($cat->nombre)) == trim($nombre)){
                    Yii::$app->session->setFlash('danger', "Cateogria: ".$model->nombre.", YA EXISTE.");
                    echo "<script>window.history.back();</script>";
                    die;
                }
            }
            $model->nombre = rtrim(ltrim($model->nombre));

            if ($model->save()) {
                Yii::$app->session->setFlash('warning', "Categoría ".$model->nombre.", actualizada.");
            }else{
                Yii::$app->session->setFlash('danger', "Categoría ".$model->nombre.", NO SE PUDO actualizar.");
                echo "<script>window.history.back();</script>";
                die;
            }

            $bit = new Bitacora();
            $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
            $bit->fecha = date('Y-m-d');
            $bit->descripcion = 'Actualizar Categoría de producto: '.$model->nombre.'.';
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
     * Deletes an existing CategoriaP model.
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
            Yii::$app->session->setFlash('danger', "Categoría ".$model->nombre.", eliminada.");
        }else{
            Yii::$app->session->setFlash('info', "Categoría ".$model->nombre.", NO SE PUDO eliminar.");
            echo "<script>window.history.back();</script>";
            die;
        }
        $bit = new Bitacora();
        $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
        $bit->fecha = date('Y-m-d');
        $bit->descripcion = 'Eliminar Categoría de producto: '.$model->nombre.'.';
        if(!$bit->save()){
            print_r($bit->getErrors());
            die;
        };

        echo "<script>window.history.back();</script>";
        die;
    }

    /**
     * Finds the CategoriaP model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoriaP the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategoriaP::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }



}
