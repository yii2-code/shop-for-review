<?php

namespace shop\migrations;

use yii\db\Migration;

/**
 * Class m180118_085821_shop_user_add_column
 */
class m180118_085821_shop_user_add_column extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'password_reset_token', $this->string(100)->unique()->after('request_email_token'));
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'password_reset_token');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180118_085821_shop_user_add_column cannot be reverted.\n";

        return false;
    }
    */
}
