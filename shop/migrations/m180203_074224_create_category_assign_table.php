<?php

namespace shop\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `category_assign`.
 */
class m180203_074224_create_category_assign_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%category_assign}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], $options);

        $this->addForeignKey(
            'fk-category_assign-product',
            '{{%category_assign}}',
            'product_id',
            '{{%product}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-category_assign-category',
            '{{%category_assign}}',
            'category_id',
            '{{%category}}',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->createIndex(
            'ui-category-assign-product_id-category_id',
            '{{%category_assign}}',
            ['product_id', 'category_id'],
            true
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%category_assign}}');
    }
}
