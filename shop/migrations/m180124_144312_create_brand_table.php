<?php

namespace shop\migrations;

use yii\db\Migration;

/**
 * Class m180124_144312_create_brand_table
 */
class m180124_144312_create_brand_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%brand}}',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string(512)->notNull(),
                'description' => $this->text(),
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
        $this->dropTable('{{%brand}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180124_144312_create_brand_table cannot be reverted.\n";

        return false;
    }
    */
}
