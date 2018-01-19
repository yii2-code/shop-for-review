<?php

namespace shop\migrations;

use yii\db\Migration;

/**
 * Class m180119_111655_shop_user_alter_column
 */
class m180119_111655_shop_user_alter_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->alterColumn('{{%user}}', 'request_email_token', $this->string(100));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->alterColumn('{{%user}}', 'request_email_token', $this->string(64));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180119_111655_shop_user_alter_column cannot be reverted.\n";

        return false;
    }
    */
}
