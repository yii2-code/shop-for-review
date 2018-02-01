<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 18:55
 */

namespace shop\types\Product;


use shop\entities\Product\Characteristic;
use yii\base\Model;

/**
 * Class CharacteristicType
 * @package shop\types\Product
 */
class CharacteristicType extends Model
{
    /**
     * @var
     */
    public $title;

    /**
     * @var
     */
    public $type;

    /**
     * @var
     */
    public $required;

    /**
     * @var
     */
    public $default;

    /**
     * @var
     */
    public $variants = [];

    /**
     * @var Characteristic
     */
    public $model;


    /**
     * CharacteristicType constructor.
     * @param Characteristic|null $model
     * @param array $config
     */
    public function __construct(
        Characteristic $model = null,
        array $config = []
    )
    {
        parent::__construct($config);
        if (is_null($model)) {
            $this->model = new Characteristic();
        } else {
            $this->title = $model->title;
            $this->type = $model->type;
            $this->required = $model->required;
            $this->default = $model->default;
            $this->variants = $model->variants;
            $this->model = $model;
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['title', 'trim'],
            [['title', 'type', 'required'], 'required'],
            [['default'], 'string'],
            [['title'], 'string', 'max' => 100],
            [['type', 'required'], 'integer'],
            ['variants', 'safe'],
            [['type', 'required'], 'filter', 'filter' => 'intval'],
        ];
    }
}