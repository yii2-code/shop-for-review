<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 02.02.18
 * Time: 14:39
 */

declare(strict_types=1);

namespace shop\services\Product;


use shop\entities\Product\Characteristic;
use shop\entities\Product\Value;
use shop\entities\repositories\Product\ValueRepository;
use shop\services\BaseService;
use shop\types\Product\ValueType;

/**
 * Class ValueService
 * @package shop\services\Product
 */
class ValueService
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var ValueRepository
     */
    private $valueRepository;

    /**
     * ValueService constructor.
     * @param BaseService $baseService
     * @param ValueRepository $valueRepository
     */
    public function __construct(
        BaseService $baseService,
        ValueRepository $valueRepository
    )
    {
        $this->baseService = $baseService;
        $this->valueRepository = $valueRepository;
    }


    /**
     * @param Characteristic $characteristic
     * @param Value|null $model
     * @return ValueType
     */
    public function createType(Characteristic $characteristic, Value $model = null)
    {
        return new ValueType($characteristic, $model);
    }

    /**
     * @param int $productId
     * @param $characteristicId
     * @param ValueType $type
     * @return Value
     */
    public function create(int $productId, $characteristicId, ValueType $type): Value
    {
        $value = Value::create($productId, $characteristicId, empty($type->value) ? null : $type->value);
        $this->baseService->save($value);
        return $value;
    }

    /**
     * @param int $id
     * @param ValueType $type
     * @return Value
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit(int $id, ValueType $type): Value
    {
        $value = $this->valueRepository->findOne($id);
        $this->baseService->notFoundHttpException($value);
        $value->edit(empty($type->value) ? null : $type->value);
        $this->baseService->save($value);
        return $value;
    }
}