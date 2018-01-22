<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 22.01.18
 * Time: 19:39
 */

namespace shop\entities\repositories;


use shop\entities\Auth\Auth;

/**
 * Class AuthRepository
 * @package shop\entities\repositories
 */
class AuthRepository
{
    /**
     * @param string $source
     * @param string $sourceId
     * @return null|Auth
     */
    public function findOneBy(string $source, string $sourceId): ?Auth
    {
        return Auth::find()->source($source)->sourceId($sourceId)->limit(1)->one();
    }
}