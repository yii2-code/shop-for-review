<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 21:15
 */

namespace shop\tests\unit\services\Auth\UserService;


use shop\services\Auth\UserService;
use Yii;

class Unit extends \Codeception\Test\Unit
{
    /** @var UserService */
    public $service;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function _before()
    {
        $this->service = Yii::createObject(UserService::class);
    }
}