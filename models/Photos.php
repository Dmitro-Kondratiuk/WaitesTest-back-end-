<?php

namespace app\models;

/**
 * This is the model class for table "photos".
 *
 * @property int $id
 * @property string $link
 * @property int|null $post_id
 */
class Photos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['link','post_id'], 'required'],
            [['post_id'], 'integer'],
            [['link'], 'string', 'max' => 255],
        ];
    }
    public function fields()
    {
        $fields =  parent::fields();
        unset($fields['post_id'],$fields['id']);
        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link' => 'Link',
            'post_id' => 'Post ID',
        ];
    }
}
