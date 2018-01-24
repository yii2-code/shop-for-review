<?php

namespace shop\migrations;

use shop\entities\Product\Category;
use yii\db\Migration;

/**
 * Class m180123_143533_shop_category_create_table
 */
class m180123_143533_shop_category_create_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%category}}',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string(512)->notNull(),
                'description' => $this->text(),
                'lft' => $this->integer()->notNull(),
                'rgt' => $this->integer()->notNull(),
                'depth' => $this->integer()->notNull(), // not unsigned!
                'status' => $this->integer()->notNull()->defaultValue(0),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $options
        );

        $this->createIndex('lft', '{{%category}}', ['lft', 'rgt']);
        $this->createIndex('rgt', '{{%category}}', ['rgt']);

        $this->insert(
            '{{%category}}',
            [
                'title' => '',
                'description' => '',
                'lft' => 1,
                'rgt' => 2,
                'depth' => 0,
                'status' => Category::STATUS_ACTIVE,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180123_143533_shop_category_create_table cannot be reverted.\n";

        return false;
    }
    */
}
