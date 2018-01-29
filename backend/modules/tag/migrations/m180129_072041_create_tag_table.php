<?php

namespace backend\modules\tag\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `tag`.
 */
class m180129_072041_create_tag_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%tag}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->unique()->notNull(),
        ], $options);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%tag}}');
    }
}
