<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 23:19
 */

namespace shop\tests\unit\types\Auth;


use Codeception\Test\Unit;
use shop\types\Auth\ResetPasswordType;

class ResetPasswordTypeTest extends Unit
{
    public function testSuccess()
    {
        $type = new ResetPasswordType();
        $type->password = 'password';
        $type->repeatPassword = 'password';
        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    public function testRequired()
    {
        $type = new ResetPasswordType();
        $this->assertFalse($type->validate(), 'The type is validate');
        $this->assertArrayHasKey('password', $type->getErrors(), 'Property password has not error');
        $this->assertArrayHasKey('repeatPassword', $type->getErrors(), 'Property repeatPassword has not error');
    }

    public function testLess()
    {
        $type = new ResetPasswordType();
        $type->password = 'pas';
        $this->assertFalse($type->validate(), 'The type is validate');
        $this->assertArrayHasKey('password', $type->getErrors(), 'Property password has not error');
    }

    public function testGreat()
    {
        $type = new ResetPasswordType();
        $type->password = str_repeat('t', 101);
        $this->assertFalse($type->validate(), 'The type is validate');
        $this->assertArrayHasKey('password', $type->getErrors(), 'Property password has not error');
    }
}