<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 14:41
 */

namespace shop\tests\unit\services\Auth\PasswordResetService;


use DomainException;
use shop\helpers\UserHelper;
use shop\types\Auth\ResetPasswordType;

/**
 * Class ResetPasswordTest
 * @package shop\tests\unit\services\Auth\PasswordResetService
 */
class ResetPasswordTest extends Unit
{

    /**
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $user = $this->grabUser(2);

        $type = new ResetPasswordType();
        $type->password = 'password';
        $type->repeatPassword = 'password';
        $model = $this->service->resetPassword($user->password_reset_token, $type);
        $model->validate($type->password);
        $this->assertNull($model->password_reset_token);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function testNotFound()
    {
        $type = new ResetPasswordType();
        $type->password = 'password';
        $type->repeatPassword = 'password';

        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('The required user does not exist');
        $this->service->resetPassword(UserHelper::generatePasswordReset(), $type);
    }
}