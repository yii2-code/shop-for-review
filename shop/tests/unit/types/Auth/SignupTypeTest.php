<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 17:41
 */

namespace shop\tests\unit\types\Auth;

use Codeception\Test\Unit;
use shop\types\User\SignupType;

class SignupTypeTest extends Unit
{
    public function testSuccess()
    {
        $type = new SignupType();
        $type->login = 'login';
        $type->email = 'test@email.com';
        $type->password = 'password';
        $this->assertTrue($type->validate());
    }

    public function testRequired()
    {
        $type = new SignupType();
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('login', $type->getErrors());
        $this->assertArrayHasKey('email', $type->getErrors());
        $this->assertArrayHasKey('password', $type->getErrors());
    }

    public function testEmail()
    {
        $type = new SignupType();
        $type->email = 'tests';
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('email', $type->getErrors());
    }

    public function testPassword()
    {
        $type = new SignupType();
        $type->password = 'tst';
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('password', $type->getErrors());
    }
}