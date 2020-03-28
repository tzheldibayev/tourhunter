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
            'balance' => $this->decimal(10, 2)->notNull()->defaultValue(0.00),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('NOW()'),
        ]);

        for ($i = 1; $i <= 10; $i++) {
            $this->insert('users', [
                'username' => 'test '. $i,
                'auth_key' => \Yii::$app->security->generateRandomString(),
                'access_token' => \Yii::$app->security->generateRandomString(),
            ]);
        }
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
