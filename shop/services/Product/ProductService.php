<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 19:34
 */

namespace shop\services\Product;

use backend\modules\image\Module;
use backend\modules\image\services\ImageManager;
use backend\modules\tag\services\TagAssignService;
use Exception;
use shop\entities\Product\Product;
use shop\entities\repositories\Product\ProductRepository;
use shop\services\BaseService;
use shop\types\Product\PriceType;
use shop\types\Product\ProductCreateType;
use shop\types\Product\ProductEditType;

/**
 * Class ProductService
 * @package shop\services\Product
 */
class ProductService
{
    /**
     * @var BaseService
     */
    private $baseService;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /** @var ImageManager */
    private $imageManager;

    /**
     * @var TagAssignService
     */
    private $tagAssignService;

    /**
     * ProductService constructor.
     * @param BaseService $baseService
     * @param ProductRepository $productRepository
     * @param TagAssignService $tagAssignService
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct(
        BaseService $baseService,
        ProductRepository $productRepository,
        TagAssignService $tagAssignService
    )
    {
        $this->baseService = $baseService;
        $this->productRepository = $productRepository;
        $this->imageManager = \Yii::createObject(Module::IMAGE);
        $this->tagAssignService = $tagAssignService;
    }

    /**
     * @param Product|null $model
     * @return ProductCreateType|ProductEditType
     */
    public function createType(Product $model = null)
    {
        if (is_null($model)) {
            return new ProductCreateType();
        } else {
            return new ProductEditType($model);
        }

    }

    /**
     * @param ProductCreateType $productType
     * @param PriceType $priceType
     * @return Product
     * @throws \yii\base\Exception
     * @throws Exception
     */
    public function create(ProductCreateType $productType, PriceType $priceType): Product
    {
        $transaction = \Yii::$app->db->beginTransaction();
        try {
            $product = Product::create(
                $productType->title,
                $productType->announce,
                $productType->description,
                $productType->status,
                $priceType->price,
                $productType->brandId,
                $productType->categoryMainId,
                $priceType->oldPrice
            );
            $this->baseService->save($product);
            $this->imageManager->createService()->editAfterCreatedRecord($product->id, $product::className());
            $this->tagAssignService->assign(Product::class, $product->id, explode(',', $productType->tags));
            $transaction->commit();
        } catch (Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }
        return $product;
    }

    /**
     * @param int $id
     * @param ProductEditType $type
     * @return Product
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit(int $id, ProductEditType $type): Product
    {
        $product = $this->productRepository->findOne($id);
        $this->baseService->notFoundHttpException($product);
        $product->edit(
            $type->title,
            $type->announce,
            $type->description,
            $type->status,
            $type->brandId,
            $type->categoryMainId
        );

        $this->baseService->save($product);
        $this->tagAssignService->assign(Product::class, $product->id, explode(',', $type->tags));
        return $product;
    }

    /**
     * @param int $id
     * @param PriceType $type
     * @return Product
     * @throws \yii\web\NotFoundHttpException
     */
    public function editPrice(int $id, PriceType $type): Product
    {
        $product = $this->productRepository->findOne($id);
        $this->baseService->notFoundHttpException($product);
        $product->editPrice($type->price, $type->oldPrice);
        $this->baseService->save($product);
        return $product;
    }
}