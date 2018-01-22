<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 15:13
 */

namespace shop\tests\unit\types\Auth;


use Codeception\Test\Unit;
use shop\types\Auth\SignInType;

class SignInTypeTest extends Unit
{
    public function testSuccess()
    {
        $type = new SignInType();
        $type->login = 'test';
        $type->password = 'password';
        $this->assertTrue($type->validate(), 'The Model does not validate');
    }

    public function testRequired()
    {
        $type = new SignInType();
        $this->assertFalse($type->validate(), 'The Model validates');
        $this->assertArrayHasKey('login', $type->getErrors(), 'Property login has not error');
        $this->assertArrayHasKey('login', $type->getErrors(), 'Property password has not error');
    }
}