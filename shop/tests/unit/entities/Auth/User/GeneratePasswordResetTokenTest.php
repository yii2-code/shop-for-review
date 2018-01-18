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
 * Class GeneratePasswordResetTokenTest
 * @package shop\tests\unit\entities\Auth\User
 */
class GeneratePasswordResetTokenTest extends Unit
{

    /**
     * @throws \yii\base\Exception
     */
    public function testSuccess()
    {
        $model = new User();
        $model->generatePasswordResetToken();
        $token = $model->password_reset_token;
        $timestamp = substr($token, strrpos($token, '_') + 1);
        $this->assertEquals(date('Y-m-d'), date('Y-m-d', $timestamp), 'Token is invalid');
    }
}