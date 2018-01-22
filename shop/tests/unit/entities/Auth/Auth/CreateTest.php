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
use shop\tests\fixtures\UserFixture;
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

    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . '/user.php',
            ]
        ]);

        $user = $this->tester->grabFixture('user', 2);

        $auth = Auth::create($user->id, 'source1', 'sourceId1');
        $this->assertTrue($auth->save(), 'Unable to save model');
    }

    public function testUser()
    {
        $this->expectException(DomainException::class);
        $this->expectExceptionMessage('Incorrectly user');
        Auth::create(1, 'source', 'sourceId');
    }
}