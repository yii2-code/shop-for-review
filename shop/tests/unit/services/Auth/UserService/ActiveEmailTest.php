<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 18:38
 */

namespace shop\tests\unit\services\Auth\UserService;

use shop\entities\Auth\User;
use shop\tests\fixtures\UserFixture;
use shop\tests\UnitTester;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Class ActiveEmailTest
 * @package shop\tests\unit\services\Auth\UserService
 */
class ActiveEmailTest extends Unit
{

    /** @var UnitTester */
    protected $tester;

    /**
     * @throws NotFoundHttpException
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . '/user.php',
            ]
        ]);

        /** @var User $user1 */
        $user1 = $this->tester->grabFixture('user', 1);

        $model = $this->service->activeEmail($user1->request_email_token);
        $this->assertEquals(User::STATUS_ACTIVE, $model->status, 'Property status does not equal');

        /** @var User $user2 */
        $user2 = $this->tester->grabFixture('user', 1);

        $this->service->activeEmail($user2->request_email_token);
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
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . '/user.php',
            ]
        ]);

        /** @var User $user */
        $user = $this->tester->grabFixture('user', 3);

        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('The required page does not exist');

        $this->service->activeEmail($user->request_email_token);
    }
}