<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 23.01.18
 * Time: 22:46
 */

namespace shop\entities\query\Product;


use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
    use NestedSetsQueryTrait;
}