<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 03.02.18
 * Time: 16:58
 */

declare(strict_types=1);

namespace shop\services\Product;


use shop\entities\Product\CategoryAssign;
use shop\entities\Product\Product;
use shop\entities\repositories\Product\ProductRepository;
use shop\services\BaseService;
use shop\types\Product\CategoryAssignType;

/**
 * Class CategoryAssignService
 * @package shop\services\Product
 */
class CategoryAssignService
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * CategoryAssignService constructor.
     * @param BaseService $baseService
     * @param ProductRepository $productRepository
     */
    public function __construct(
        BaseService $baseService,
        ProductRepository $productRepository
    )
    {
        $this->baseService = $baseService;
        $this->productRepository = $productRepository;
    }

    /**
     * @param Product $model
     * @return CategoryAssignType
     */
    public function createType(Product $model = null): CategoryAssignType
    {
        return new CategoryAssignType($model);
    }

    /**
     * @param Product $product
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function deletes(Product $product)
    {
        $categoryAssigns = $product->categoryAssigns;
        foreach ($categoryAssigns as $categoryAssign) {
            $this->baseService->delete($categoryAssign);
        }
    }

    /**
     * @param int $productId
     * @param array $categories
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function creates(int $productId, array $categories)
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $product = $this->productRepository->findOne($productId);
            $this->baseService->notFoundHttpException($product);
            $this->deletes($product);
            foreach ($categories as $category) {
                $this->create($productId, $category);
            }
            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }

    /**
     * @param int $productId
     * @param int $categoryId
     * @return CategoryAssign
     * @throws \yii\base\InvalidConfigException
     */
    public function create(int $productId, int $categoryId): CategoryAssign
    {
        $categoryAssign = CategoryAssign::create($productId, $categoryId);
        $this->baseService->save($categoryAssign);
        return $categoryAssign;
    }
}