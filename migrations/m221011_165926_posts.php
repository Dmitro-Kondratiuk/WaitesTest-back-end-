<?php

use yii\db\Migration;

/**
 * Class m221011_165926_posts
 */
class m221011_165926_posts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'name' => $this->string(200)->notNull(),
            'description' => $this->string(1000)->notNull(),
            'price'=>$this->integer()->notNull(),
            'links'=>$this->string()->null(),
            'user_id'=>$this->integer()->notNull(),
            'created_at'=>$this->date()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('posts');
    }
}
