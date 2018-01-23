<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 15:25
 */

namespace shop\tests\unit\services\Auth\PasswordResetService;

use shop\helpers\UserHelper;

/**
 * Class ValidatePasswordTest
 * @package shop\tests\unit\services\Auth\PasswordResetService
 */
class ValidatePasswordTest extends Unit
{
    /**
     * @group auth
     * @throws \yii\base\Exception
     */
    public function testSuccess()
    {
        $this->assertTrue($this->service->validatePasswordReset(UserHelper::generatePasswordReset(), 3600));
    }

    /**
     * @group auth
     */
    public function testEmpty()
    {
        $this->assertFalse($this->service->validatePasswordReset('', 3600));
    }

    /**
     * @group auth
     * @throws \yii\base\Exception
     */
    public function testExpire()
    {
        $this->assertFalse($this->service->validatePasswordReset(UserHelper::generatePasswordReset(), -3600));
    }

    /**
     * @group auth
     */
    public function testNumeric()
    {
        $this->assertFalse($this->service->validatePasswordReset('fsdfsdfsdf_fdfsdfsdf', 3600));
    }
}