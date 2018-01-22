<?php

namespace shop\migrations;

use yii\db\Migration;

/**
 * Class m180117_111530_shop_user_create_table
 */
class m180117_111530_shop_user_create_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%user}}',
            [
                'id' => $this->primaryKey(),
                'login' => $this->string(100)->notNull()->unique(),
                'password' => $this->string(100)->notNull(),
                'email' => $this->string(100)->notNull()->unique(),
                'email_active_token' => $this->string(100)->unique(),
                'password_reset_token' => $this->string(100)->unique(),
                'status' => $this->integer()->notNull()->defaultValue(0),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $options
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180117_111530_shop_user_create_table cannot be reverted.\n";

        return false;
    }
    */
}
