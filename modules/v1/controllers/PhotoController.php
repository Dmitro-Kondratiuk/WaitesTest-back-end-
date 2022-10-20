<?php

namespace app\modules\v1\controllers;

use app\models\Photos;

class PhotoController extends BaseApiController
{
    public $modelClass = Photos::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    public function actionCreate()
    {
        $arr = \Yii::$app->request->bodyParams;
        foreach ($arr['photos'] as $photo) {
            $model = new Photos();
            $model->link = $photo;
            $model->post_id = $arr['post_id'];
            $model->validate();
            $model->save();
        }
        return [
            'resultCode' => 0
        ];
    }

}