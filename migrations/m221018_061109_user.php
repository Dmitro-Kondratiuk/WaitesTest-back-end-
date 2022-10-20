<?php

use yii\db\Migration;

/**
 * Class m221018_061109_user
 */
class m221018_061109_user extends Migration
{
    public function up()

    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'last_name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'access_token' => $this->string(255),
        ]);
    }


    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('user');
    }

}
