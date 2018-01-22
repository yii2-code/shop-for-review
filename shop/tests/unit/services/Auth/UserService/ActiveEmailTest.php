<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 18:38
 */

namespace shop\tests\unit\services\Auth\UserService;

use shop\entities\Auth\User;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class ActiveEmailTest
 * @package shop\tests\unit\services\Auth\UserService
 */
class ActiveEmailTest extends Unit
{

    /**
     * @throws NotFoundHttpException
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $user1 = $this->grabUser(1);

        $model = $this->service->activeEmail($user1->email_active_token);
        $this->assertEquals(User::STATUS_ACTIVE, $model->status, 'Property status does not equal');

        /** @var User $user2 */
        $user2 = $this->grabUser(2);

        $this->service->activeEmail($user2->email_active_token);
    }


    /**
     * @throws \yii\base\Exception
     */
    public function testNotFound()
    {
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('The required page does not exist');
        $this->service->activeEmail(sprintf('%s_%s', Yii::$app->security->generateRandomString(64), time()));
    }

    /**
     * @throws \yii\base\Exception
     */
    public function testEmpty()
    {
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('The required page does not exist');
        $this->service->activeEmail('');
    }

    /**
     * @throws NotFoundHttpException
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testDelete()
    {
        $user = $this->grabUser(3);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('The required page does not exist');

        $this->service->activeEmail($user->email_active_token);
    }
}