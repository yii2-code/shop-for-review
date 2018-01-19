<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 20:39
 */

namespace shop\tests\unit\types\Auth;


use Codeception\Test\Unit;
use shop\entities\Auth\User;
use shop\tests\fixtures\UserFixture;
use shop\tests\UnitTester;
use shop\types\Auth\RequestPasswordResetType;

/**
 * Class RequestPasswordResetTypeTest
 * @package shop\tests\unit\types\Auth
 */
class RequestPasswordResetTypeTest extends Unit
{

    /**
     * @var UnitTester
     */
    protected $tester;

    /**
     * @throws \shop\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . '/user.php'
            ]
        ]);


        /** @var $user User */
        $user = $this->tester->grabFixture('user', 1);

        $type = new RequestPasswordResetType();
        $type->email = $user->email;

        $this->assertTrue($type->validate(), 'The model is not validate');
    }

    /**
     *
     */
    public function testRequired()
    {
        $type = new RequestPasswordResetType();

        $this->assertFalse($type->validate(), 'The model is validate');
        $this->assertArrayHasKey('email', $type->getErrors(), 'The email has not error');
    }

    /**
     *
     */
    public function testExists()
    {
        $type = new RequestPasswordResetType();
        $type->email = 'test@email.ru';
        $this->assertFalse($type->validate(), 'The model is validate');
        $this->assertArrayHasKey('email', $type->getErrors(), 'The email has not error');
    }

    /**
     *
     */
    public function testEmail()
    {
        $type = new RequestPasswordResetType();
        $type->email = 'test@email.ru';
        $this->assertFalse($type->validate(), 'The model is validate');
        $this->assertArrayHasKey('email', $type->getErrors(), 'The email has not error');
    }
}