<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 16:39
 */

namespace shop\tests\unit\entities\Auth\User;


use Codeception\Test\Unit;
use shop\entities\Auth\User;

/**
 * Class GenerateResetTokenTest
 * @package shop\tests\unit\entities\Auth\User
 */
class GenerateResetTokenTest extends Unit
{

    /**
     * @throws \yii\base\Exception
     */
    public function testSuccess()
    {
        $model = new User();
        $model->generatePasswordResetToken();
        $token = $model->password_reset_token;
        codecept_debug($model->password_reset_token);
        $timestamp = substr($token, strpos($token, '_') + 1);
        $this->assertEquals(date('Y-m-d'), date('Y-m-d', $timestamp), 'Token is invalid');
    }
}