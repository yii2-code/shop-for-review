<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 23.01.18
 * Time: 23:07
 */

namespace shop\types\Product;


use shop\entities\Product\Category;
use yii\base\Model;

/**
 * Class CategoryType
 * @package shop\types\Product
 */
class CategoryType extends Model
{
    /**
     * @var
     */
    public $title;
    /**
     * @var
     */
    public $description;
    /**
     * @var
     */
    public $status;
    /**
     * @var mixed
     */
    public $categoryId;

    /**
     * @var Category
     */
    public $model;

    /**
     * CategoryType constructor.
     * @param Category $model
     * @param array $config
     */
    public function __construct(
        Category $model = null,
        array $config = []
    )
    {
        parent::__construct($config);
        if (!is_null($model) && !$model->isNewRecord) {
            $this->title = $model->title;
            $this->description = $model->description;
            $this->status = $model->status;
            $parent = $model->getParent()->one();
            if (!$parent->isRoot()) {
                $this->categoryId = $parent->id;
            }
            $this->model = $model;
        } else {
            $this->model = new Category();
        }
    }


    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'description', 'status'], 'trim'],
            [['title', 'description', 'status'], 'required'],
            [['title'], 'string', 'max' => 512],
            ['description', 'string'],
            ['status', 'integer'],
            [['status'], 'filter', 'filter' => 'intval'],
            ['categoryId', 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['categoryId' => 'id']]
        ];
    }
}