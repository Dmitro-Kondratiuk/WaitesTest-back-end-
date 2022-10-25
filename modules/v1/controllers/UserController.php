<?php

namespace app\modules\v1\controllers;


use app\models\Users;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class UserController extends BaseApiController
{

    public $modelClass = 'app\models\Users';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'register', 'me','logout'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['logout','me','update','view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete','logout'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        $actions = ArrayHelper::merge(parent::actions(), [
            'index' => [
                'pagination' => [
                    'pageSize' => 10,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC
                    ],
                ],
            ],
        ]);
        return $actions;
    }


    public function verbs()
    {
        parent::verbs();
        return [
            'me' => ['GET'],
            'register' => ['POST'],
            'login' => ['POST'],
            'logout' => ['DELETE'],
        ];
    }


//Register()- method POST
    public function actionRegister()
    {
        $item = Yii::$app->request->post();
        $model = new Users();
        if (!Users::findOne(['username'=>$item['username']])) {
            $model->username = $item['username'];
            $model->password = Yii::$app->getSecurity()->generatePasswordHash($item['password']);
            $model->name = $item['name'];
            $model->last_name = $item['last_name'];
            $model->email = $item['email'];
            $model->validate();
            if ($model->save()) {
                if($model->id == 1){
                    $userRole = Yii::$app->authManager->getRole('user');
                    Yii::$app->authManager->assign($userRole, $model->id);
                    return [
                        'resultCode' => 0
                    ];
            } else {
                return [
                    'error' => 'Fields are not checked',
                    'resultCode' => 1
                ];
            }
        } else {
            return [
                'error' => "Пользыватель с таким логином уже существует",
                'resultCode' => 1
            ];
        }
    }

//login() method Login
    public function actionLogin()
    {

        $arr = Yii::$app->request->post();
        $model = Users::findOne(['username' => $arr['username']]);
        if ($model->username) {
            if ($model->password == Yii::$app->getSecurity()->validatePassword($arr['password'], $model['password'])) {
                if (!$model->access_token) {
                    $model->access_token = Yii::$app->security->generateRandomString(255);
                }
                $model->validate();
                if ($model->save())
                    return [
                        'access_token' => $model->access_token,
                        'resultCode' => 0
                    ];
            } else {
                return [
                    'error' => "Неверно указан пароль или логин",
                    'resultCode' => 1,
                ];
            }
        } else {
            return ['error' => 'Такого юзера не существет'];
        }

    }

//logout () method Delete
    public function actionLogout()
    {
        $model = Users::findOne(Yii::$app->user->identity->id);
        $model->access_token = null;
        if ($model->save()) {
            return ['resultCode' => 0];
        } else {
            return ['resultCode' => 1];
        }
    }

    public function actionMe()
    {
        return [
            'id' => Yii::$app->user->identity->id,
            'name' => Yii::$app->user->identity->name,
            'last_name' => Yii::$app->user->identity->last_name,
            'email' => Yii::$app->user->identity->email,
        ];
    }


}
