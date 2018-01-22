<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 15:36
 */

namespace shop\tests\unit\services\Auth\UserService;

use DomainException;
use shop\entities\Auth\User;
use shop\tests\UnitTester;
use shop\types\Auth\SignInType;

/**
 * Class SignInTest
 * @package shop\tests\unit\services\Auth\UserService
 */
class SignInTest extends Unit
{

    /** @var UnitTester */
    protected $tester;

    /**
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $user = $this->grabUser(2);
        $type = new SignInType();
        $type->login = $user->login;
        $type->password = 'password2';

        $user = $this->service->signIn($type);

        $this->assertInstanceOf(User::class, $user, sprintf('The class %s is not instance of %s', $user::className(), User::class));
    }

    /**
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testNotLogin()
    {
        $type = new SignInType();
        $type->login = 'invalid';
        $type->password = 'invalid';


        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('The Login and Password is not valid');
        $this->service->signIn($type);

        $user = $this->grabUser(2);

        $type = new SignInType();
        $type->login = $user->login;
        $type->password = 'invalid';

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('The Login and Password is not valid');
        $this->service->signIn($type);
    }


    /**
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testConfirmEmail()
    {
        $user = $this->grabUser(1);

        $type = new SignInType();
        $type->login = $user->login;
        $type->password = 'password1';


        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('You must active email');
        $this->service->signIn($type);
        $this->tester->seeEmailIsSent(1);
    }

    /**
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testDelete()
    {
        $user = $this->grabUser(3);

        $type = new SignInType();
        $type->login = $user->login;
        $type->password = 'password3';

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('You is blocked');
        $this->service->signIn($type);
    }
}