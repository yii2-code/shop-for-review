<?php

namespace shop\migrations;

use yii\db\Migration;


/**
 * Class m180122_091757_shop_auth_create_tabel
 */
class m180122_091757_shop_auth_create_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%auth}}',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'source' => $this->string()->notNull(),
                'source_id' => $this->string()->notNull(),
            ],
            $options
        );

        $this->addForeignKey(
            'fk-user-auth',
            '{{%auth}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%auth}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180122_091757_shop_auth_create_tabel cannot be reverted.\n";

        return false;
    }
    */
}
