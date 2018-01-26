<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 22:20
 */

namespace shop\types\Product;


use shop\entities\Product\Product;
use yii\base\Model;

/**
 * Class PriceType
 * @package shop\types\Product
 */
class PriceType extends Model
{
    /**
     * @var int
     */
    public $price;
    /**
     * @var int
     */
    public $oldPrice;

    /**
     * @var Product
     */
    public $model;

    /**
     * PriceType constructor.
     * @param Product|null $model
     * @param array $config
     */
    public function __construct(Product $model = null, array $config = [])
    {
        if (!is_null($model)) {
            $this->model = $model;
            $this->price = $model->price;
            $this->oldPrice = $model->old_price;
        } else {
            $this->model = new Product();
        }
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['price', 'required'],
            [['price', 'oldPrice'], 'integer'],
            [['price', 'oldPrice'], 'filter', 'filter' => 'intval'],
        ];
    }


}