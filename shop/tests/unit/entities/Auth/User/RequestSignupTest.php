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
     * @var \shop\tests\UnitTester
     */
    protected $tester;


    /**
     * @throws \yii\base\Exception
     */
    public function testSuccess()
    {
        $model = User::requestSignup(
            $password = 'password',
            $login = 'login',
            $email = 'email@test.com'
        );

        $this->assertNotEmpty($model->request_email_token, 'request_email_token is empty');
        $this->assertTrue($model->validatePassword($password));
        $this->assertTrue($model->save());

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
     * @throws \yii\base\Exception
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testFailedOnEmail()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => '@shop/tests/_data/user.php',
            ]
        ]);

        /** @var $user User */
        $user = $this->tester->grabFixture('user', '1');

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('');
        $model = User::requestSignup(
            $password = 'password',
            $login = 'login',
            $email = $user->email
        );
    }
}