<?php

namespace shop\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `value`.
 */
class m180202_053521_create_value_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%value}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer()->notNull(),
            'characteristic_id' => $this->integer()->notNull(),
            'value' => $this->string(100),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ]);

        $this->createIndex(
            'ui-value-product_id-characteristic_id',
            '{{%value}}',
            ['product_id', 'characteristic_id'],
            true
        );

        $this->addForeignKey(
            'fk-value-product',
            '{{%value}}',
            'product_id',
            '{{%product}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-value-characteristic',
            '{{%value}}',
            'product_id',
            '{{%characteristic}}',
            'id',
            'RESTRICT',
            'RESTRICT'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%value}}');
    }
}
