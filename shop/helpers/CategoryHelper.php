<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 17:33
 */

declare(strict_types=1);

namespace shop\helpers;

use shop\entities\Product\Category;
use shop\entities\repositories\Product\CategoryRepository;
use Yii;

/**
 * Class CategoryHelper
 * @package shop\helpers
 */
class CategoryHelper
{
    /**
     * @return array
     */
    public static function getDropDown(): array
    {
        return [
            Category::STATUS_ACTIVE => Yii::t('shop', 'Active'),
            Category::STATUS_DELETE => Yii::t('shop', 'Delete'),
        ];
    }

    /**
     * @return array
     */
    public static function getTree(): array
    {
        $root = (new CategoryRepository())->findOneRoot();
        $categories = $root->getDescendants()->indexBy('id')->all();
        $list = array_map(function (Category $category) {
            return str_repeat('-', $category->depth - 1) . $category->title;
        }, $categories);
        return $list;
    }
}