<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 17:41
 */

namespace shop\tests\unit\types\Auth;

use Codeception\Test\Unit;
use shop\entities\Auth\User;
use shop\tests\fixtures\UserFixture;
use shop\tests\UnitTester;
use shop\types\Auth\SignupType;

class SignupTypeTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    public function testSuccess()
    {
        $type = new SignupType();
        $type->login = 'login';
        $type->email = 'test@email.com';
        $type->password = 'password';
        $type->repeatPassword = 'password';
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

    public function testGreat()
    {
        $type = new SignupType();
        $type->password = 'tst';
        $type->login = 'ts';
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('password', $type->getErrors());
        $this->assertArrayHasKey('login', $type->getErrors());
    }

    /**
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testUnique()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => '@shop/tests/_data/user.php'
            ]
        ]);

        /** @var User $user */
        $user = $this->tester->grabFixture('user', 1);

        $type = new SignupType();
        $type->login = $user->login;
        $type->email = $user->email;
        $this->assertFalse($type->validate());
        $this->assertArrayHasKey('password', $type->getErrors());
    }
}