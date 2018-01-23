<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 17.01.18
 * Time: 17:08
 */

namespace shop\tests\unit\entities\Auth\User;

use Codeception\Test\Unit;
use DomainException;
use shop\entities\Auth\User;
use shop\tests\fixtures\UserFixture;

/**
 * Class RequestSignupTest
 * @package shop\tests\unit\entities\Auth\User
 */
class RequestSignupTest extends Unit
{
    /**
     * @group auth
     * @var \shop\tests\UnitTester
     */
    protected $tester;


    /**
     * @group auth
     * @throws \yii\base\Exception
     */
    public function testSuccess()
    {
        $model = User::requestSignup(
            $password = 'password',
            $login = 'login',
            $email = 'email@test.com'
        );

        $this->assertNotEmpty($model->email_active_token, 'email_active_token is empty');
        $this->assertTrue($model->validatePassword($password), 'Unable to validate password');
        $this->assertTrue($model->save(), 'Unable to save model');

        $this->tester->seeRecord(
            User::class,
            [
                'id' => $model->id,
                'login' => $login,
                'email' => $model->email,
                'status' => $model->status,
            ]
        );
    }


    /**
     * @group auth
     * @throws \yii\base\Exception
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testEmail()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . '/user.php',
            ]
        ]);

        /** @var $user User */
        $user = $this->tester->grabFixture('user', '1');

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(sprintf('Email "%s" has already been token', $user->email));
        User::requestSignup(
            $password = 'password',
            $login = 'login',
            $email = $user->email
        );
    }

    /**
     * @group auth
     * @throws \shop\tests\_generated\ModuleException
     * @throws \yii\base\Exception
     */
    public function testLogin()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . '/user.php',
            ]
        ]);

        /** @var $user User */
        $user = $this->tester->grabFixture('user', '1');

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage(sprintf('Login "%s" has already been token', $user->login));

        User::requestSignup(
            $password = 'password',
            $login = $user->login,
            $email = 'email@test2.com'
        );
    }
}