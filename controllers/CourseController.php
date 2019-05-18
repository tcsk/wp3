<?php

namespace app\controllers;

use app\models\Scedule;
use thamtech\uuid\helpers\UuidHelper;
use Yii;
use app\models\Course;
use app\models\CourseSearch;
use yii\data\ActiveDataProvider;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use \Throwable;
use \PHPExcel_IOFactory;
use DateTime;

/**
 * CourseController implements the CRUD actions for Course model.
 */
class CourseController extends Controller {

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
                        'roles' => ['teacher'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Course models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Course model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        $dataProvider = new ActiveDataProvider([
            'query' => $model->getScedules(),
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new Course model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Course();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Course model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     * @throws StaleObjectException
     * @throws Throwable
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Course model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Course the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Course::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    private function store($file, $course) {
        $model = $this->findModel($course);
        foreach ($model->scedules as $scedule) {
            $scedule->delete();
        }
        $objPHPExcel = PHPExcel_IOFactory::load('./uploads/' . $file);
        $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

        foreach ($sheetData as $data) {
            $scedule = new Scedule();
            $scedule->course_id = $course;
            $scedule->title = $data['A'];
            $scedule->description = $data['B'];
            $date = new DateTime($data['C']);
            $scedule->deadline = $date->format('Y-m-d H:i:s');
            $scedule->save();
        }
    }

    public function actionUpload() {
        $post = Yii::$app->request->post();
        $valid_extensions = array('xls');
        $path = Yii::$app->basePath . '/web/uploads/';
        if ($_FILES['file']) {

            $file = $_FILES['file']['name'];
            $tmp = $_FILES['file']['tmp_name'];

            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $uuid = UuidHelper::uuid();
            $final_file = $uuid . '.' . $ext;

            if (in_array($ext, $valid_extensions)) {
                $path = $path . strtolower($final_file);
                if (move_uploaded_file($tmp, $path)) {
                    $this->store($final_file, $post['course']);
                    return 'success';
                }
            } else {
                return 'invalid';
            }
        }
    }
}
