<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 17:25
 */

namespace shop\tests\unit\services\Auth\UserService;


use Codeception\Test\Unit;
use shop\entities\Auth\Profile;
use shop\entities\Auth\User;
use shop\services\Auth\UserService;
use shop\types\Auth\SignupType;
use Yii;

class SignupTest extends Unit
{
    /**
     * @var \shop\tests\UnitTester
     */
    protected $tester;

    /**
     * @group auth
     * @throws \Exception
     * @throws \shop\tests\_generated\ModuleException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function testSuccessSendEmail()
    {
        /** @var UserService $service */
        $service = Yii::createObject(UserService::class);
        $type = new SignupType();
        $type->login = 'login';
        $type->password = 'password';
        $type->repeatPassword = 'password';
        $type->email = 'test@email';
        $model = $service->signup($type);
        $this->tester->seeEmailIsSent(1);

        $this->tester->seeRecord(User::class, ['id' => $model->id, 'login' => $type->login, 'email' => $type->email]);
        $this->tester->seeRecord(Profile::class, ['user_id' => $model->id]);
    }
}