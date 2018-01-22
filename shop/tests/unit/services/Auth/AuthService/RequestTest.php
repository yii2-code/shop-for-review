<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 22.01.18
 * Time: 18:01
 */

namespace shop\tests\unit\services\Auth\AuthService;


use Codeception\Test\Unit;
use DomainException;
use shop\entities\Auth\Auth;
use shop\entities\Auth\User;
use shop\services\Auth\AuthService;
use shop\tests\fixtures\AuthFixture;
use shop\tests\fixtures\UserFixture;

class RequestTest extends Unit
{
    /** @var \shop\tests\UnitTester */
    protected $tester;

    /** @var AuthService */
    public $service;

    public function _before()
    {
        $this->service = \Yii::createObject(AuthService::class);
    }

    public function grabUser($index): User
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . '/user.php',
            ],
            'auth' => [
                'class' => AuthFixture::class,
                'dataFile' => codecept_data_dir() . '/auth.php',
            ]
        ]);

        return $this->tester->grabFixture('user', $index);

    }

    public function testFirstAuthentication()
    {

        $user = $this->service->request($login = 'Login', $email = 'test@email.com', $source = 'source', $sourceId = 'sourceId');
        $this->tester->seeRecord(User::class, ['login' => $login, 'email' => $email]);
        $this->tester->seeRecord(Auth::class, ['user_id' => $user->id, 'source' => $source, 'source_id' => $sourceId]);
    }

    public function testAuthentication()
    {
        $user = $this->grabUser(2);
        $auth = current($user->auths);

        $model = $this->service->request($login = 'Login', $email = 'test@email.com', $auth->source, $auth->source_id);
        $this->assertEquals($user->id, $model->id);
    }

    public function testEmail()
    {
        $user = $this->grabUser(4);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('User with the same email account already exists');
        $this->service->request('Login', $user->email, 'source', 'sourceId');
    }

    public function testLogin()
    {
        $user = $this->grabUser(4);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('User with the same login account already exists');
        $this->service->request($user->login, 'test@emal.com', 'source', 'sourceId');
    }


    public function testStatus()
    {
        $user = $this->grabUser(3);

        $auth = current($user->auths);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Your account is blocked');
        $this->service->request($user->login, $user->email, $auth->source, $auth->source_id);
    }
}