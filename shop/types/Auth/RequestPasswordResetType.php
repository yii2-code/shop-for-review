<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 20:37
 */

namespace shop\types\Auth;


use shop\entities\Auth\User;
use yii\base\Model;

/**
 * Class RequestPasswordResetType
 * @package shop\types\Auth
 */
class RequestPasswordResetType extends Model
{
    /**
     * @var
     */
    public $email;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist', 'targetClass' => User::class],
        ];
    }
}