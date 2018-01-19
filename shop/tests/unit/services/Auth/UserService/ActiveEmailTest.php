<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 18:38
 */

namespace shop\tests\unit\services\Auth\UserService;


use Codeception\Test\Unit;
use shop\entities\Auth\User;
use shop\services\Auth\UserService;
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
     * @throws \yii\base\InvalidConfigException
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

        /** @var UserService $service */
        $service = Yii::createObject(UserService::class);
        $model = $service->activeEmail($user1->request_email_token);
        $this->assertEquals(User::STATUS_ACTIVE, $model->status, 'Property status does not equal');

        /** @var User $user2 */
        $user2 = $this->tester->grabFixture('user', 1);

        /** @var UserService $service */
        $service = Yii::createObject(UserService::class);
        $service->activeEmail($user2->request_email_token);
    }


    /**
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function testNotFound()
    {
        /** @var UserService $service */
        $service = Yii::createObject(UserService::class);
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('The required page does not exist');
        $service->activeEmail(sprintf('%s_%s', Yii::$app->security->generateRandomString(64), time()));
    }

    /**
     * @throws \yii\base\Exception
     * @throws \yii\base\InvalidConfigException
     */
    public function testEmpty()
    {
        /** @var UserService $service */
        $service = Yii::createObject(UserService::class);
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('The required page does not exist');
        $service->activeEmail('');
    }

    /**
     * @throws NotFoundHttpException
     * @throws \shop\tests\_generated\ModuleException
     * @throws \yii\base\InvalidConfigException
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

        /** @var UserService $service */
        $service = Yii::createObject(UserService::class);
        $this->expectException(NotFoundHttpException::class);
        $this->expectExceptionMessage('The required page does not exist');

        $service->activeEmail($user->request_email_token);
    }
}