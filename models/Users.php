<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $last_name
 * @property string $email
 * @property string|null $access_token
 */
class Users extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
//            [['username', 'password'], 'required'],
            [['username', 'password', 'name', 'last_name', 'email', 'access_token'], 'string', 'max' => 255],
        ];
    }
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['username'], $fields['password'],$fields['access_token']);
        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'access_token' => 'Access Token',
        ];
    }
}
