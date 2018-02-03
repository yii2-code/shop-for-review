<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 03.02.18
 * Time: 16:18
 */

namespace shop\types\Product;


use shop\entities\Product\Category;
use shop\entities\Product\Product;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoryAssignType extends Model
{
    public $categories;

    public function __construct(Product $product = null, $config = [])
    {
        parent::__construct($config);
        if (!is_null($product)) {
            $categories = $product->categories;
            $this->categories = ArrayHelper::getColumn($categories, 'id');
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['categories', 'each', 'rule' => ['exist', 'targetClass' => Category::class, 'targetAttribute' => 'id']],
            ['categories', 'default', 'value' => []],
            ['categories', 'each', 'rule' => ['filter', 'filter' => 'intval']],
        ];
    }
}