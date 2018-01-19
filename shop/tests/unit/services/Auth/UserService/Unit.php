<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 21:15
 */

namespace shop\tests\unit\services\Auth\UserService;


use shop\entities\Auth\User;
use shop\services\Auth\UserService;
use shop\tests\fixtures\UserFixture;
use shop\tests\UnitTester;
use Yii;

/**
 * Class Unit
 * @package shop\tests\unit\services\Auth\UserService
 */
class Unit extends \Codeception\Test\Unit
{
    /** @var UnitTester */
    protected $tester;

    /** @var UserService */
    public $service;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function _before()
    {
        $this->service = Yii::createObject(UserService::class);
    }

    /**
     * @param int $index
     * @return User
     * @throws \shop\tests\_generated\ModuleException
     */
    public function grabUser(int $index)
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . '/user.php',
            ]
        ]);

        return $this->tester->grabFixture('user', $index);
    }
}