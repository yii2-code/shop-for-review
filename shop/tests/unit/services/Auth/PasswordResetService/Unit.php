<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 14:35
 */

namespace shop\tests\unit\services\Auth\PasswordResetService;


use shop\entities\Auth\User;
use shop\services\Auth\PasswordResetService;
use shop\tests\fixtures\UserFixture;
use shop\tests\UnitTester;
use Yii;

class Unit extends \Codeception\Test\Unit
{
    /** @var UnitTester */
    protected $tester;

    /** @var PasswordResetService */
    public $service;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function _before()
    {
        $this->service = Yii::createObject(PasswordResetService::class);
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