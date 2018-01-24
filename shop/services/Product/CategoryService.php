<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 15:58
 */

declare(strict_types=1);

namespace shop\services\Product;

use shop\entities\Product\Category;
use shop\entities\repositories\Product\CategoryRepository;
use shop\services\BaseService;
use shop\types\Product\CategoryType;

/**
 * Class CategoryService
 * @package shop\services\Product
 */
class CategoryService
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param BaseService $baseService
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(
        BaseService $baseService,
        CategoryRepository $categoryRepository
    )
    {
        $this->baseService = $baseService;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param CategoryType $type
     * @return Category
     */
    public function create(CategoryType $type): Category
    {
        $category = Category::create($type->title, $type->description, $type->status);
        $parent = $this->getParent($type->categoryId);
        $category->appendTo($parent);
        $this->baseService->save($category);
        return $category;
    }

    /**
     * @param int $id
     * @param CategoryType $type
     * @return Category
     */
    public function edit(int $id, CategoryType $type): Category
    {
        $category = $this->categoryRepository->findOne($id);
        $category->edit($type->title, $type->description, $type->status);
        $parent = $this->getParent($type->categoryId);
        $category->appendTo($parent);
        $this->baseService->save($category);
        return $category;
    }

    /**
     * @param $id
     * @return Category
     */
    public function getParent($id): Category
    {
        if (is_numeric($id)) {
            $parent = $this->categoryRepository->findOne((int)$id);
        } else {
            $parent = $this->categoryRepository->findOneRoot();
        }

        return $parent;
    }
}