<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 14:22
 */

namespace common\fixtures;

use shop\entities\Auth\User;
use yii\test\ActiveFixture;

/**
 * Class UserFixture
 * @package common\fixtures
 */
class UserFixture extends ActiveFixture
{
    /**
     * UserFixture constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->modelClass = User::class;
        parent::__construct($config);
    }
}