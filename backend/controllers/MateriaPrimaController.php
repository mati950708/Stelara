<?php

namespace backend\controllers;

use backend\models\Bitacora;
use Yii;
use backend\models\MateriaPrima;
use backend\models\MateriaPrimaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MateriaPrimaController implements the CRUD actions for MateriaPrima model.
 */
class MateriaPrimaController extends Controller
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
     * Lists all MateriaPrima models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MateriaPrimaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MateriaPrima model.
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
     * Creates a new MateriaPrima model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MateriaPrima();

        if ($model->load(Yii::$app->request->post())) {
            $model->id = Yii::$app->db2->createCommand("SELECT nextval('proveedor_id_seq');")->queryAll()[0]['nextval'];

            $bit = new Bitacora();
            $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
            $bit->fecha = date('Y-m-d');
            $bit->descripcion = 'Agregar Materia prima: '.$model->nombre.'.';
            if(!$bit->save()){
                print_r($bit->getErrors());
                die;
            };


            if ($model->save()) {
                echo "<script>window.history.back();</script>";
                die;
            }
        }

        return $this->renderAjax('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MateriaPrima model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $bit = new Bitacora();
            $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
            $bit->fecha = date('Y-m-d');
            $bit->descripcion = 'Actualizar Materia prima: '.$model->nombre.'.';
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
     * Deletes an existing MateriaPrima model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $this->findModel($id)->delete();

        $bit = new Bitacora();
        $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
        $bit->fecha = date('Y-m-d');
        $bit->descripcion = 'Eliminar Materia prima: '.$model->nombre.'.';
        if(!$bit->save()){
            print_r($bit->getErrors());
            die;
        };
        echo "<script>window.history.back();</script>";
    }

    /**
     * Finds the MateriaPrima model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MateriaPrima the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MateriaPrima::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
