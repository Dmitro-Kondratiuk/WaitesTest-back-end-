<?php

use yii\db\Migration;

/**
 * Class m221011_170710_photo
 */
class m221011_170710_photo extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()

    {
        $this->createTable('photos', [
            'id' => $this->primaryKey(),
            'link' => $this->string()->notNull(),
            'post_id' => $this->integer(),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('photos');
    }


}
