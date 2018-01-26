<?php

namespace shop\migrations;

use yii\db\Migration;

/**
 * Class m180125_101514_shop_product_create_table
 */
class m180125_101514_shop_product_create_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable(
            '{{%product}}',
            [
                'id' => $this->primaryKey(),
                'title' => $this->string(512)->notNull(),
                'announce' => $this->text(),
                'description' => $this->text(),
                'price' => $this->integer()->notNull(),
                'old_price' => $this->integer(),
                'category_main_id' => $this->integer()->notNull(),
                'brand_id' => $this->integer()->notNull(),
                'status' => $this->integer()->notNull()->defaultValue(0),
                'created_at' => $this->dateTime()->notNull(),
                'updated_at' => $this->dateTime()->notNull(),
            ],
            $options
        );

        $this->addForeignKey(
            'fk-product-brand',
            '{{%product}}',
            'brand_id',
            '{{%brand}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-product-category',
            '{{%product}}',
            'category_main_id',
            '{{%category}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180125_101514_shop_product_create_table cannot be reverted.\n";

        return false;
    }
    */
}
