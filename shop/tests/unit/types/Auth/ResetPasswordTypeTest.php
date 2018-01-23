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

/**
 * Class ResetPasswordTypeTest
 * @package shop\tests\unit\types\Auth
 */
class ResetPasswordTypeTest extends Unit
{
    /**
     * @group auth
     */
    public function testSuccess()
    {
        $type = new ResetPasswordType();
        $type->password = 'password';
        $type->repeatPassword = 'password';
        $this->assertTrue($type->validate(), 'Unable to validate type');
    }

    /**
     * @group auth
     */
    public function testRequired()
    {
        $type = new ResetPasswordType();
        $this->assertFalse($type->validate(), 'The type is validate');
        $this->assertArrayHasKey('password', $type->getErrors(), 'Property password has not error');
        $this->assertArrayHasKey('repeatPassword', $type->getErrors(), 'Property repeatPassword has not error');
    }

    /**
     * @group auth
     */
    public function testLess()
    {
        $type = new ResetPasswordType();
        $type->password = 'pas';
        $this->assertFalse($type->validate(), 'The type is validate');
        $this->assertArrayHasKey('password', $type->getErrors(), 'Property password has not error');
    }

    /**
     * @group auth
     */
    public function testGreat()
    {
        $type = new ResetPasswordType();
        $type->password = str_repeat('t', 101);
        $this->assertFalse($type->validate(), 'The type is validate');
        $this->assertArrayHasKey('password', $type->getErrors(), 'Property password has not error');
    }
}