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

    public function rules()
    {
        return [
            [['title', 'description', 'status'], 'required'],
            [['title'], 'string', 'max' => 512],
            ['description', 'string'],
            ['status', 'integer'],
            ['categoryId', 'exist', 'targetClass' => Category::class, 'targetAttribute' => ['categoryId' => 'id']]
        ];
    }
}