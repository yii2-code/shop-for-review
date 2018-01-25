<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 22:56
 */

declare(strict_types=1);

namespace shop\services\Product;

use shop\entities\Product\Brand;
use shop\entities\repositories\Product\BrandRepository;
use shop\services\BaseService;
use shop\types\Product\BrandType;

/**
 * Class BrandService
 * @package shop\services\Product
 */
class BrandService
{
    /**
     * @var BaseService
     */
    private $baseService;

    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * BrandService constructor.
     * @param BaseService $baseService
     * @param BrandRepository $brandRepository
     */
    public function __construct(
        BaseService $baseService,
        BrandRepository $brandRepository
    )
    {

        $this->baseService = $baseService;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @param Brand|null $model
     * @return BrandType
     */
    public function createType(Brand $model = null): BrandType
    {
        return new BrandType($model);
    }

    /**
     * @param BrandType $type
     * @return Brand
     */
    public function create(BrandType $type): Brand
    {
        $brand = Brand::create($type->title, $type->description, $type->status);
        $this->baseService->save($brand);
        return $brand;
    }

    /**
     * @param int $id
     * @param BrandType $type
     * @return Brand
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit(int $id, BrandType $type): Brand
    {
        $brand = $this->brandRepository->findOne($id);
        $this->baseService->notFoundHttpException($brand);
        $brand->edit($type->title, $type->description, $type->status);
        $this->baseService->save($brand);
        return $brand;
    }
}