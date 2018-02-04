<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 14:22
 */

namespace shop\tests\fixtures;


use shop\entities\Auth\User;
use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public function __construct(array $config = [])
    {
        $this->modelClass = User::class;
        $this->dataFile = codecept_data_dir('/user.php');
        parent::__construct($config);
    }
}