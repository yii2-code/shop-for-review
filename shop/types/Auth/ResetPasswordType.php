<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 19.01.18
 * Time: 22:55
 */

declare(strict_types=1);

namespace shop\types\Auth;


use yii\base\Model;

/**
 * Class ResetPasswordType
 * @package shop\types\Auth
 */
class ResetPasswordType extends Model
{
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
            [['password', 'repeatPassword'], 'trim'],
            [['password', 'repeatPassword'], 'required'],
            [['repeatPassword'], 'string'],
            [['password'], 'string', 'min' => '6', 'max' => 100],
        ];
    }
}