<?php

namespace app\controllers;

use app\rules\AuthorRole;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
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
    public function actions()
    {
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
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

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
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
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionRole()
    {
        $user = Yii::$app->authManager->createRole('admin');
        $user->description = "admin";
        Yii::$app->authManager->add($user);
        $userRole = Yii::$app->authManager->getRole('admin');
        Yii::$app->authManager->assign($userRole, $model->id);

        $user = Yii::$app->authManager->createRole('user');
        $user->description = "user";
        Yii::$app->authManager->add($user);



        $admin = Yii::$app->authManager->createPermission('canAdmin');
        $admin->description = "Право на вход в админку";
        Yii::$app->authManager->add($admin);

        $user = Yii::$app->authManager->createPermission('updatePost');
        $user->description = "Право на редактирование постов";
        Yii::$app->authManager->add($user);

        $role = Yii::$app->authManager->getRole('admin');
        $permit = Yii::$app->authManager->getPermission('updatePost');
        Yii::$app->authManager->addChild($role,$permit);


        $auth = Yii::$app->authManager;
        $rule = new AuthorRole();
        $auth->add($rule);
        $updateOwnPost = $auth->createPermission('updateOwnPost');
        $updateOwnPost->description = "Редактирование собственных постов";
        $auth->add($updateOwnPost);

        $role = Yii::$app->authManager->getRole('user');
        $permit = Yii::$app->authManager->getPermission('updateOwnPost');
        Yii::$app->authManager->addChild($role,$permit);


        return " Я все сделал";
    }
}
