<?php

use yii\db\Migration;

/**
 * Class m200327_131229_create_users_tables
 */
class m200327_131229_create_users_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->unique()->notNull(),
            'access_token' => $this->string()->unique()->notNull(),
            'auth_key' => $this->string()->unique()->notNull(),
            'balance' => $this->decimal()->notNull()->defaultValue(0.00)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200327_131229_create_users_tables cannot be reverted.\n";

        return false;
    }
    */
}
