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

class CategoryType extends Model
{
    public $title;
    public $description;
    public $status;
    public $categoryId;
    /**
     * @var Category
     */
    private $model;

    public function __construct(
        Category $model,
        array $config = []
    )
    {
        parent::__construct($config);
        if (!$model->isNewRecord) {
            $this->title = $model->title;
            $this->description = $model->description;
            $this->status = $model->status;
            $parent = $model->getParent()->one();
            if (!$parent->isRoot()) {
                $this->categoryId = $parent->id;
            }
        }
        $this->model = $model;
    }


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