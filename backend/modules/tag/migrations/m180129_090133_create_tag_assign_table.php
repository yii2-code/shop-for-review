<?php

namespace backend\modules\tag\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `tag_assign`.
 */
class m180129_090133_create_tag_assign_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('{{%tag_assign}}', [
            'id' => $this->primaryKey(),
            'class' => $this->string(100)->notNull(),
            'record_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-tag_assign-tag',
            '{{%tag_assign}}',
            'tag_id',
            '{{%tag}}',
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
        $this->dropTable('{{%tag_assign}}');
    }
}
