<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 22.01.18
 * Time: 17:28
 */

namespace shop\tests\unit\entities\Auth\Auth;


use Codeception\Test\Unit;
use DomainException;
use shop\entities\Auth\Auth;
use shop\entities\Auth\Profile;
use shop\entities\Auth\User;
use shop\tests\UnitTester;

/**
 * Class CreateTest
 * @package shop\tests\unit\entities\Auth\Auth
 */
class CreateTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @group auth
     * @throws \Exception
     * @throws \Throwable
     * @throws \shop\tests\_generated\ModuleException
     * @throws \yii\db\StaleObjectException
     */
    public function testSuccess()
    {
        User::deleteAll();
        $this->tester->have(User::class, ['id' => 1]);

        /** @var $user User */
        $user = $this->tester->grabRecord(User::class, ['id' => 1]);

        $auth = Auth::create($user->id, 'source', 'sourceId');
        $this->assertTrue($auth->save(), 'Unable to save model');
        $this->assertNotFalse($auth->delete(), 'Unable to save model');
    }

    /**
     * @group auth
     */
    public function testUser()
    {
        Profile::deleteAll();
        User::deleteAll();
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Incorrectly user');
        Auth::create(1, 'source', 'sourceId');
    }
}