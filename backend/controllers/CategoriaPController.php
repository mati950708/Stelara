<?php

namespace backend\controllers;

use Yii;
use backend\models\CategoriaP;
use backend\models\CategoriaPSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use kartik\mpdf\Pdf;

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
            $model->id = Yii::$app->db2->createCommand("SELECT nextval('categoria_p_id_seq');")->queryAll()[0]['nextval'];
            $model->estado = 0;

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
     * Updates an existing CategoriaP model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
        $model->save();

        echo "<script>window.history.back();</script>";
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


    public function actionReport() {

        \yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        //\yii::$app->response->headers->add('Content-Type', 'application/pdf');

        // get your HTML raw content without any layouts or scripts
        $searchModel = new CategoriaPSearch();
        $data = $searchModel->search(Yii::$app->request->queryParams);
        $content = $this->renderPartial('report', [
            'dataProvider' => $data,
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf();
        $pdf->content = $content;
        $pdf->methods = [
            'SetHeader'=>['Reporte de Categorias'],
            'SetFooter'=>['{PAGENO}'],
        ];
        $pdf->options = ['title' => 'Report Categoría'];

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
