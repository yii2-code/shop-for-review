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
use shop\services\Auth\UserService;
use shop\tests\stubs\services\BaseService;
use shop\types\Auth\SignupType;
use Yii;

class SignupTest extends Unit
{
    /**
     * @var \shop\tests\UnitTester
     */
    protected $tester;

    /**
     * @throws \shop\tests\_generated\ModuleException
     * @throws \yii\base\Exception
     */
    public function testSuccessSendEmail()
    {
        /** @var UserService $service */
        $service = Yii::createObject(UserService::class, [new BaseService()]);
        $type = new SignupType();
        $type->login = 'login';
        $type->password = 'password';
        $type->repeatPassword = 'password';
        $type->email = 'test@email';
        $model = $service->signup($type);
        $this->assertInstanceOf(User::class, $model, sprintf('%s does not instance of %s', $model::className(), User::class));
        $this->tester->seeEmailIsSent(1);
    }
}