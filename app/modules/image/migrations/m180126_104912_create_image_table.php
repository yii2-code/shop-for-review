<?php

namespace app\modules\image\migrations;

use yii\db\Migration;

/**
 * Class m180126_104912_create_image_table
 */
class m180126_104912_create_image_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;


        $this->createTable(
            '{{%image}}',
            [
                'id' => $this->primaryKey(),
                'src' => $this->string(100)->notNull(),
                'name' => $this->string(100)->notNull(),
                'class' => $this->string(100)->notNull(),
                'record_id' => $this->integer(),
                'token' => $this->string(100),
                'position' => $this->integer()->notNull(),
                'main' => $this->integer(),
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
        $this->dropTable('{{%image}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180126_104912_create_image_table cannot be reverted.\n";

        return false;
    }
    */
}
