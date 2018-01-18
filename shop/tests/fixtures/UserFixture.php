<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 14:22
 */

namespace shop\tests\fixtures;


use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'shop\entities\Auth\User';
}