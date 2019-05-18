<?php

namespace app\controllers;

use app\models\Course;
use app\models\CourseSearch;
use app\models\File;
use app\models\Scedule;
use DateTime;
use PHPExcel_IOFactory;
use thamtech\uuid\helpers\UuidHelper;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use kartik\mpdf\Pdf;

class StudentCourseController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getScedules(),
        ]);
        $docDataProvider = new ActiveDataProvider([
            'query' => $model->getFiles(),
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'docDataProvider' => $docDataProvider,
            'pdf' => false
        ]);
    }

    protected function findModel($id) {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionReport($id) {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getScedules(),
        ]);
        $docDataProvider = new ActiveDataProvider([
            'query' => $model->getFiles(),
        ]);
        $content = $this->renderPartial('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'docDataProvider' => $docDataProvider,
            'pdf' => true
        ]);

        // setup kartik\mpdf\Pdf component
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_UTF8,
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
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px}',
            // set mPDF properties on the fly
            'options' => ['title' => 'Krajee Report Title'],
            // call mPDF methods on the fly
            'methods' => [
                'SetHeader' => ['WP3 kurzus adatlap'],
                'SetFooter' => ['{PAGENO}'],
            ]
        ]);

        // return the pdf output as per the destination setting
        return $pdf->render();
    }

    public function actionUpload() {
        $post = Yii::$app->request->post();
        $path = Yii::$app->basePath . '/web/uploads/';
        if ($_FILES['file']) {

            $file = $_FILES['file']['name'];
            $tmp = $_FILES['file']['tmp_name'];

            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $uuid = UuidHelper::uuid();
            $final_file = $uuid . '.' . $ext;
            $path = $path . strtolower($final_file);
            if (move_uploaded_file($tmp, $path)) {
                $file = new File();
                $file->title = $post['title'];
                $file->filename = $final_file;
                $file->course_id = $post['course'];
                $file->save();
                return json_encode($file->getErrors());
            } else {
                return 'success';
            }
        }
    }

}
