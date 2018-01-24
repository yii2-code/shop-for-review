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

    public function __construct(
        BaseService $baseService,
        BrandRepository $brandRepository
    )
    {

        $this->baseService = $baseService;
        $this->brandRepository = $brandRepository;
    }


    public function createType(Brand $model): BrandType
    {

    }

    public function create(BrandType $type): Brand
    {

    }

    public function edit(int $id, BrandType $type): Brand
    {

    }
}