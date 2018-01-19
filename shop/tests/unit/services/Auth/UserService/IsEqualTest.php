<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 22:05
 */

namespace shop\tests\unit\services\Auth\UserService;

/**
 * Class IsEqualTest
 * @package shop\tests\unit\services\Auth\UserService
 */
class IsEqualTest extends Unit
{
    public function testSuccess()
    {
        $this->assertTrue($this->service->isEqual('password', 'password'), 'Password is not equal to resetPassword');
    }

    public function testFailed()
    {
        $this->assertFalse($this->service->isEqual('password', 'password3'), 'Password is equal resetPassword');
    }
}