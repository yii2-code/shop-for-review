<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 22:05
 */

namespace shop\tests\unit\services\Auth\UserService;


use Codeception\Test\Unit;
use shop\services\Auth\UserService;

/**
 * Class IsEqualTest
 * @package shop\tests\unit\services\Auth\UserService
 */
class IsEqualTest extends Unit
{
    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function testSuccess()
    {
        /** @var UserService $service */
        $service = \Yii::createObject(UserService::class);
        $this->assertTrue($service->isEqual('password', 'password'));
    }

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function testFailed()
    {
        /** @var UserService $service */
        $service = \Yii::createObject(UserService::class);
        $this->assertFalse($service->isEqual('password', 'password3'));
    }
}