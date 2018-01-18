<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 20:29
 */

namespace shop\types\Auth;


use shop\entities\Auth\User;
use yii\base\Model;

/**
 * Class SignupType
 * @package shop\types\Auth
 */
class SignupType extends Model
{
    /**
     * @var
     */
    public $login;
    /**
     * @var
     */
    public $email;
    /**
     * @var
     */
    public $password;
    /**
     * @var
     */
    public $repeatPassword;


    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['login', 'email', 'password', 'repeatPassword'], 'trim'],
            [['login', 'email', 'password', 'repeatPassword'], 'required'],
            [['email', 'repeatPassword'], 'string'],
            ['password', 'string', 'min' => '6', 'max' => 100],
            ['login', 'string', 'min' => '3', 'max' => 100],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class],
            ['login', 'unique', 'targetClass' => User::class],
        ];
    }
}