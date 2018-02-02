<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 02.02.18
 * Time: 14:40
 */

namespace shop\types\Product;


use shop\entities\Product\Characteristic;
use shop\entities\Product\Value;
use yii\base\Model;

/**
 * Class ValueType
 * @package shop\types\Product
 */
class ValueType extends Model
{
    /**
     * @var
     */
    public $value;

    /**
     * @var Characteristic
     */
    public $characteristic;
    /**
     * @var Value
     */
    public $model;

    /**
     * ValueType constructor.
     * @param Characteristic $characteristic
     * @param Value|null $model
     * @param array $config
     */
    public function __construct(Characteristic $characteristic, Value $model = null, array $config = [])
    {
        parent::__construct($config);
        $this->characteristic = $characteristic;
        if (is_null($model)) {
            $this->model = new Value();
        } else {
            $this->model = $model;
            $this->value = $model->value;
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return array_filter([
            $this->characteristic->isRequired() ? ['value', 'required'] : false,
            ['value', $this->characteristic->getVariant()->rule],
            ['value', 'string', 'max' => 100],
        ]);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return ['value' => $this->characteristic->title];
    }

    /**
     * @return array
     */
    public function getDropDownList(): array
    {
        $list = array_combine($this->characteristic->variants, $this->characteristic->variants);
        if (!empty($this->characteristic->default)) {
            $list = [$this->characteristic->default => $this->characteristic->default] + $list;
        }
        return $list;
    }
}