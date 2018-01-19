<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 15:24
 */

namespace shop\types\Auth;


use yii\base\Model;

/**
 * Class SignInType
 * @package shop\types\Auth
 */
class SignInType extends Model
{
    /**
     * @var
     */
    public $login;
    /**
     * @var
     */
    public $password;


    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login', 'password'], 'string'],
        ];
    }
}