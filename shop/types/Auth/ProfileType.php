<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 15:07
 */

namespace shop\types\Auth;


use shop\entities\Auth\Profile;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * Class ProfileType
 * @package shop\types\Auth
 */
class ProfileType extends Model
{
    /**
     * @var
     */
    public $firstName;
    /**
     * @var
     */
    public $middleName;
    /**
     * @var
     */
    public $lastName;
    /**
     * @var
     */
    public $about;
    /**
     * @var
     */
    public $src;
    /**
     * @var Profile
     */
    public $model;

    /**
     * ProfileType constructor.
     * @param Profile $model
     * @param array $config
     */
    public function __construct(
        Profile $model,
        array $config = []
    )
    {

        parent::__construct($config);
        $this->model = $model;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['firstName', 'middleName', 'lastName'], 'trim'],
            [['firstName', 'middleName', 'lastName'], 'string', 'max' => '100'],
            [['about'], 'string'],
            ['src', 'image', 'mimeTypes' => 'image/*'],
            [['firstName', 'middleName', 'lastName', 'about', 'src'], 'default', 'value' => null],
        ];
    }


    /**
     * @return bool
     */
    public function beforeValidate()
    {
        $this->src = UploadedFile::getInstance($this, 'src');
        return parent::beforeValidate();
    }
}