<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 19:03
 */

namespace shop\entities\repositories\Auth;


use shop\entities\Auth\Profile;

/**
 * Class ProfileRepository
 * @package shop\entities\repositories\Auth
 */
class ProfileRepository
{
    /**
     * @param int $id
     * @return null|Profile
     */
    public function findOne(int $id): ?Profile
    {
        return Profile::find()->id($id)->limit(1)->one();
    }
}