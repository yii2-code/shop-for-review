<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 19:36
 */

namespace shop\types\Product;


use app\type\CompositeType;
use shop\entities\Product\Brand;
use shop\entities\Product\Category;

/**
 * Class ProductType
 * @package shop\types\Product
 */
class ProductCreateType extends CompositeType
{
    /**
     * @var PriceType
     */
    public $price;

    /**
     * @var
     */
    public $title;
    /**
     * @var
     */
    public $announce;
    /**
     * @var
     */
    public $description;
    /**
     * @var
     */
    public $status;
    /**
     * @var
     */
    public $brandId;
    /**
     * @var
     */
    public $categoryMainId;

    /**
     * ProductType constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->price = new PriceType();
    }

    /**
     * @return array
     */
    protected function internalForms(): array
    {
        return ['price'];
    }


    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'announce', 'description'], 'trim'],
            [['title', 'announce', 'description', 'status'], 'required'],
            ['status', 'integer'],
            ['brandId', 'exist', 'targetClass' => Brand::class, 'targetAttribute' => ['brandId' => 'id'], 'skipOnEmpty' => false],
            ['categoryMainId', 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['categoryMainId' => 'id'], 'skipOnEmpty' => false],
            [['brandId', 'categoryMainId'], 'filter', 'filter' => 'intval'],
        ];
    }
}