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
use shop\entities\repositories\Product\CharacteristicRepository;
use shop\services\Product\ValueService;

/**
 * Class ProductType
 * @package shop\types\Product
 * @property PriceType $price
 * @property ValueType[] $values
 */
class ProductCreateType extends CompositeType
{
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
     * @var
     */
    public $tags;

    /**
     * ProductType constructor.
     * @param ValueService $valueService
     * @param CharacteristicRepository $valueRepository
     * @param array $config
     */
    public function __construct(
        ValueService $valueService,
        CharacteristicRepository $valueRepository,
        array $config = []
    )
    {
        parent::__construct($config);
        $this->price = new PriceType();
        $characteristics = $valueRepository->findAll();
        $values = [];
        foreach ($characteristics as $characteristic) {
            $values[] = $valueService->createType($characteristic);
        }
        $this->values = $values;
    }

    /**
     * @return array
     */
    protected function internalForms(): array
    {
        return ['price', 'values'];
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
            [['tags', 'announce', 'description'], 'string'],
            ['brandId', 'exist', 'targetClass' => Brand::class, 'targetAttribute' => ['brandId' => 'id'], 'skipOnEmpty' => false],
            ['categoryMainId', 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['categoryMainId' => 'id'], 'skipOnEmpty' => false],
            [['brandId', 'categoryMainId', 'status'], 'filter', 'filter' => 'intval'],
        ];
    }
}