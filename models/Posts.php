<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "posts".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property string|null $links
 * @property int $user_id
 * @property string|null $created_at
 */
class Posts extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                ],
                // если вместо метки времени UNIX используется datetime:
                'value' => new Expression('NOW()'),
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'posts';
    }
    public function fields()
    {
        $fields = parent::fields();
        unset($fields['user_id'],$fields['created_at']);
        return $fields;
    }

    public function extraFields()
    {
        return ['photos','user'];
    }
    public function getPhotos(){
        return $this->hasMany(Photos::class,['post_id'=>'id']);
    }
    public function getUser(){
        return $this->hasOne(Users::class,['id'=>'user_id']);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'price'], 'required'],
            [['price', 'user_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 1000],
            [['links'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'price' => 'Price',
            'links' => 'Links',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }
}
