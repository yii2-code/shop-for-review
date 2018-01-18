<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 17:25
 */

namespace shop\tests\unit\services\Auth\UserService;


use Codeception\Test\Unit;
use shop\entities\Auth\User;
use shop\services\User\UserService;
use shop\tests\stubs\services\BaseService;
use shop\types\User\SignupType;

class SignupTest extends Unit
{
    /**
     * @var \shop\tests\UnitTester
     */
    protected $tester;

    public function testSuccessSendEmail()
    {
        /*        $service = new UserService(
                    new BaseService()
                );
                $type = new SignupType();
                $type->login = 'login';
                $type->password = 'password';
                $type->email = 'test@email';
                $model = $service->signup($type);
                $this->assertInstanceOf(User::class, $model);
                $this->tester->seeEmailIsSent(1);*/
    }
}