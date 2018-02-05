<?php

namespace shop\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `profile`.
 */
class m180205_104657_create_profile_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $options = $this->db->getDriverName() == 'mysql' ? 'ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci' : null;

        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'first_name' => $this->string(100),
            'middle_name' => $this->string(100),
            'last_name' => $this->string(100),
            'about' => $this->text(),
            'src' => $this->string(100),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ], $options);

        $this->addForeignKey(
            'fk-profile-user',
            '{{%profile}}',
            'user_id',
            '{{%user}}',
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
        $this->dropTable('{{%profile}}');
    }
}
