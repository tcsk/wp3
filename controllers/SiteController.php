<?php

namespace app\controllers;

use app\components\calendar\factory\EventListFactory;
use app\components\calendar\persistence\EventListPdoDAO;
use app\components\calendar\repository\EventListRepository;
use app\components\calendar\strategy\GetMonthlyEventListStrategy;
use app\components\calendar\strategy\GetWeeklyEventListStrategy;
use DateTime;
use yii\base\InvalidConfigException;
use yii\di\Container;
use app\models\RegisterForm;
use Yii;
use yii\di\NotInstantiableException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex() {
        /* $container = new Container();
         $container->set('app\components\calendar\strategy\contracts\GetEventListStrategy', [
             'class' => 'app\components\calendar\strategy\GetWeeklyEventListStrategy',
         ]);
         $container->set('EventListRepository', 'app\components\calendar\repository\EventListRepository');
         $eventListRepository = $container->get('EventListRepository');
         $eventListRepository->getEventList();*/

        /*$el = new EventListPdoDAO(Yii::$app->getDb()->getMasterPdo());
        $array = $el->getEventList(new DateTime('2019-02-23 00:00:00'), new DateTime('2019-05-10'));
        echo '<pre>';
        print_r($array);
        echo '</pre>';*/

        /*$dao = new EventListPdoDAO(Yii::$app->getDb()->getMasterPdo());
        $strategy = new GetWeeklyEventListStrategy($dao);
        $factory = new EventListFactory();
        $repository = new EventListRepository($strategy, $factory);
        $eventList = $repository->getEventList();*/

        $factory = new EventListFactory();
        $eventList = $factory->makeListByPeriodLength('monthly');

        echo '<pre>';
        print_r($eventList->getEventList());
        echo '</pre>';

        //return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionRegister() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            return $this->goBack();
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout() {
        return $this->render('about');
    }
}
