<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 13:55
 */

declare(strict_types=1);

namespace shop\entities\repositories;


use shop\entities\Auth\User;

/**
 * Class UserRepository
 * @package shop\entities\repositories
 */
class UserRepository
{
    /**
     * @param string $email
     * @return bool
     */
    public function existsEmail(string $email): bool
    {
        return (bool)User::find()->email($email)->exists();
    }

    /**
     * @param string $login
     * @return bool
     */
    public function existsLogin(string $login): bool
    {
        return (bool)User::find()->login($login)->exists();
    }
}