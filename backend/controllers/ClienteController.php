<?php

namespace backend\controllers;

use backend\models\Bitacora;
use Yii;
use backend\models\Cliente;
use backend\models\ClienteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Registro;

/**
 * ClienteController implements the CRUD actions for Cliente model.
 */
class ClienteController extends Controller
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
     * Lists all Cliente models.
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
        $searchModel = new ClienteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['>', 'id', '1'])->all();
        $dataProvider->query->andFilterWhere(['=', 'estado', '0'])->all();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cliente model.
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
     * Creates a new Cliente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cliente();

        if ($model->load(Yii::$app->request->post())) {
            $model->id = Yii::$app->db2->createCommand("SELECT nextval('cliente_id_seq');")->queryAll()[0]['nextval'];
            $model->estado = 0;

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Cliente ".$model->nombre.", guardado.");
            }else{
                Yii::$app->session->setFlash('danger', "Cliente ".$model->nombre.", NO SE PUDO guardar.");
                echo "<script>window.history.back();</script>";
                die;
            }
            $bit = new Bitacora();
            $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
            $bit->fecha = date('Y-m-d');
            $bit->descripcion = 'Agregar Cliente: '.$model->nombre.' '.$model->apaterno.' '.$model->amaterno.'.';
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
     * Updates an existing Cliente model.
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
                Yii::$app->session->setFlash('warning', "Cliente ".$model->nombre.", actualizado.");
            }else{
                Yii::$app->session->setFlash('danger', "Cliente ".$model->nombre.", NO SE PUDO actualizar.");
                echo "<script>window.history.back();</script>";
                die;
            }

            $bit = new Bitacora();
            $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
            $bit->fecha = date('Y-m-d');
            $bit->descripcion = 'ACtualizar Cliente: '.$model->nombre.' '.$model->apaterno.' '.$model->amaterno.'.';
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
     * Deletes an existing Cliente model.
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
            Yii::$app->session->setFlash('danger', "Cliente ".$model->nombre.", eliminado.");
        }else{
            Yii::$app->session->setFlash('info', "Cliente ".$model->nombre.", NO SE PUDO eliminar.");
            echo "<script>window.history.back();</script>";
            die;
        }

        $bit = new Bitacora();
        $bit->id = Yii::$app->db2->createCommand("SELECT nextval('bitacora_id_seq');")->queryAll()[0]['nextval'];
        $bit->fecha = date('Y-m-d');
        $bit->descripcion = 'Eliminar Cliente: '.$model->nombre.'.';
        if(!$bit->save()){
            print_r($bit->getErrors());
            die;
        };

        echo "<script>window.history.back();</script>";
        die;
    }

    /**
     * Finds the Cliente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cliente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cliente::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
