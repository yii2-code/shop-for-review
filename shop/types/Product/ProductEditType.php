<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 22:56
 */

namespace shop\types\Product;


use shop\entities\Product\Brand;
use shop\entities\Product\Category;
use shop\entities\Product\Product;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class ProductEditType
 * @package shop\types\Product
 */
class ProductEditType extends Model
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
     * @var Product
     */
    public $model;

    public $tags;
    /**
     * ProductEditType constructor.
     * @param Product $model
     * @param array $config
     */
    public function __construct(Product $model, array $config = [])
    {
        parent::__construct($config);
        $this->model = $model;
        $this->title = $model->title;
        $this->announce = $model->announce;
        $this->description = $model->description;
        $this->status = $model->status;
        $this->brandId = $model->brand_id;
        $this->categoryMainId = $model->category_main_id;
        $this->tags = implode(',', ArrayHelper::getColumn($model->tags, 'name'));
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
            [['announce', 'description', 'tags'], 'string'],
            ['brandId', 'exist', 'targetClass' => Brand::class, 'targetAttribute' => ['brandId' => 'id'], 'skipOnEmpty' => false],
            ['categoryMainId', 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['categoryMainId' => 'id'], 'skipOnEmpty' => false],
            [['brandId', 'categoryMainId', 'status'], 'filter', 'filter' => 'intval'],
        ];
    }
}