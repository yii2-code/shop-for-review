<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 17.01.18
 * Time: 17:08
 */

namespace Shop\tests\unit\entities\Auth\User;


use Codeception\Test\Unit;
use shop\entities\Auth\User;

class RequestSignupTest extends Unit
{
    public function testSuccess()
    {
        $model = User::requestSignup(
            $password = 'password',
            $login = 'login',
            $email = 'email@test.com'
        );

        $this->assertEquals($login, $model->login, 'Login does not equals');
        $this->assertEquals($email, $model->email, 'Email does not equals');
        $this->assertEquals(User::STATUS_CONFIRM_EMAIL, $model->status, 'Status does not equals');
        $this->assertNotEmpty($model->request_email_token, 'request_email_token is empty');
        $this->assertInternalType('string', $model->request_email_token, 'request_email_token is not string');
        $this->assertNotEmpty($model->password, 'password is empty');
        $this->assertInternalType('string', $model->password, 'password is not string');
        $this->assertTrue($model->validatePassword($password));
    }
}