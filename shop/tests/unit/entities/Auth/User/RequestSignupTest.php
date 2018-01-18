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

        $this->assertEquals($login, $model->login, 'Login does not equals');
        $this->assertEquals($email, $model->email, 'Email does not equals');
        $this->assertEquals(User::STATUS_CONFIRM_EMAIL, $model->status, 'Status does not equals');
        $this->assertNotEmpty($model->request_email_token, 'request_email_token is empty');
        $this->assertTrue($model->validatePassword($password));
        $this->assertTrue($model->save());
    }


    /**
     * @throws \yii\base\Exception
     */
    public function testFailedOnEmail()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => '@shop/tests/_data/user.php',
            ]
        ]);

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('');
        $model = User::requestSignup(
            $password = 'password',
            $login = 'login',
            $email = 'email@test.com'
        );
    }
}