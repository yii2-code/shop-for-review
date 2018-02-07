<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 19:10
 */

namespace shop\tests\unit\entities\Auth\Profile;


use Codeception\Test\Unit;
use shop\entities\Auth\Profile;
use shop\tests\UnitTester;
use shop\entities\Auth\User;

/**
 * Class EditTest
 * @package shop\tests\unit\entities\Auth\Profile
 */
class EditTest extends Unit
{
    /** @var UnitTester */
    protected $tester;


    /**
     * @group auth
     */
    public function testSuccess()
    {
        $profile = $this->tester->have(Profile::class);

        $profile->edit(
            $first = 'first',
            $middle = 'middle',
            $last = 'last',
            $about = 'about'
        );

        $this->assertTrue($profile->save(), 'Unable to save model');
        $this->tester->seeRecord(
            Profile::class,
            [
                'id' => $profile->id,
                'first_name' => $first,
                'middle_name' => $middle,
                'last_name' => $last,
                'about' => $about
            ]
        );
        Profile::deleteAll();
        User::deleteAll();
    }
}