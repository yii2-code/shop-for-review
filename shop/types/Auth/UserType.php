<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 11.02.18
 * Time: 22:54
 */

namespace shop\types\Auth;


use shop\entities\Auth\User;
use yii\base\Model;

/**
 * Class UserType
 * @package shop\types\Auth
 */
class UserType extends Model
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
    public $status;

    /**
     * @var User
     */
    public $model;

    /**
     * UserType constructor.
     * @param User|null $model
     * @param array $config
     */
    public function __construct(User $model = null, array $config = [])
    {
        if (!is_null($model)) {
            $this->model = $model;
            $this->login = $model->login;
            $this->email = $model->email;
            $this->status = $model->status;
        } else {
            $this->model = new User();
        }
        parent::__construct($config);

    }

    /**
     * @return array
     */
    public function rules()
    {
        return array_filter([
            [['login', 'email', 'password'], 'trim'],
            [['login', 'email'], 'required'],
            $this->model->isNewRecord ? [['password'], 'required'] : null,
            [['email'], 'string'],
            ['password', 'string', 'min' => '6', 'max' => 100],
            ['login', 'string', 'min' => '3', 'max' => 100],
            ['email', 'email'],
            ['status', 'integer'],
            ['email', 'unique', 'targetClass' => User::class, 'filter' => $this->model->isNewRecord ? null : ['NOT IN', 'id', $this->model->id]],
            ['login', 'unique', 'targetClass' => User::class, 'filter' => $this->model->isNewRecord ? null : ['NOT IN', 'id', $this->model->id]],
            [['password'], 'default', 'value' => null],
            [['status'], 'filter', 'filter' => 'intval'],
        ]);
    }
}