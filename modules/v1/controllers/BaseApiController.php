<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;


class BaseApiController extends ActiveController
{

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

}