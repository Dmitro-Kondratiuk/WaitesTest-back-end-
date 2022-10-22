<?php

namespace app\modules\v1\controllers;


use app\models\Posts;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class PostController extends BaseApiController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['update', 'index', 'create', 'delete', 'view'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public $modelClass = 'app\models\Posts';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['delete'], $actions['update']);
        $actions = ArrayHelper::merge($actions, [
            'index' => [
                'pagination' => [
                    'pageSize' => 10,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'price' => SORT_ASC,
                        'created_at' => SORT_ASC
                    ],
                ],
            ],
        ]);
        return $actions;
    }

    public function actionCreate()
    {
        $arr = Yii::$app->request->bodyParams;
        $model = new Posts();
        $model->name = $arr['name'];
        $model->description = $arr['description'];
        $model->price = $arr['price'];
        $model->links = $arr['links'];
        $model->user_id = Yii::$app->user->identity->id;
        $model->save();
        if ($model->save()) {
            return [
                'id' => $model->id,
                'resultCode' => 0
            ];
        } else {
            return [
                'error' => 'Fields are not checked',
                'resultCode' => 1
            ];
        }
    }

    public function actionDelete()
    {
        $item = Posts::findOne($_GET['id']);
        if ($item) {
            $item->delete();
            return [
                'resultCode' => 0
            ];
        } else {
            return [
                'resultCode' => 1
            ];
        }

    }

    public function actionUpdate()
    {

            $arr = Yii::$app->request->bodyParams;
            $model = Posts::findOne($_GET['id']);
            $model->name = $arr['name'];
            $model->description = $arr['description'];
            $model->price = $arr['price'];
            $model->links = $arr['links'];
            $model->validate();
            if ($model->save()) {
                return ['resultCode' => 0];
            } else {
                return [
                    'resultCode' => 1
                ];
            }
        }




}