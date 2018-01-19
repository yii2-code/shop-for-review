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
     * @param string $login
     * @return null|User
     */
    public function findOneByLogin(string $login): ?User
    {
        return User::find()->login($login)->limit(1)->one();
    }

    /**
     * @param string $token
     * @return null|User
     */
    public function findOneByRequestEmailToken(string $token): ?User
    {
        return User::find()->requestEmailToken($token)->limit(1)->one();
    }

    /**
     * @param string $email
     * @return null|User
     */
    public function findOneByEmail(string $email): ?User
    {
        return User::find()->email($email)->limit(1)->one();
    }

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