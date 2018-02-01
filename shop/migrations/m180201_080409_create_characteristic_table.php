<?php

namespace shop\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `characteristic`.
 */
class m180201_080409_create_characteristic_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;


        $this->createTable('{{%characteristic}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(100)->notNull(),
            'type' => $this->integer()->notNull(),
            'required' => $this->integer()->notNull()->defaultValue('0'),
            'default' => $this->string(100),
            'variants' => 'JSON NOT NULL',
            'position' => $this->integer()->notNull(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ], $options);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%characteristic}}');
    }
}
