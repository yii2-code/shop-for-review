<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 20:36
 */

namespace shop\tests\unit\services\Auth\UserService;


use shop\types\Auth\RequestPasswordResetType;
use yii\web\NotFoundHttpException;

/**
 * Class RequestPasswordResetTokenTest
 * @package shop\tests\unit\services\Auth\UserService
 */
class RequestPasswordResetTokenTest extends Unit
{
    /**
     * @throws NotFoundHttpException
     * @throws \shop\tests\_generated\ModuleException
     * @throws \yii\base\Exception
     */
    public function testSuccess()
    {
        $user = $this->grabUser(1);

        $type = new RequestPasswordResetType();
        $this->assertNull($user->password_reset_token);
        $type->email = $user->email;
        $model = $this->service->requestPasswordReset($type);
        $this->assertNotNull($model->password_reset_token);
    }

    /**
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function testNotFound()
    {
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('The required page does not exist');

        $type = new RequestPasswordResetType();
        $type->email = 'test@email.com';
        $this->service->requestPasswordReset($type);
    }
}