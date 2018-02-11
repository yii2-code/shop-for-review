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
use shop\entities\Product\Product;
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
    public function createType(Characteristic $characteristic, Value $model = null): ValueType
    {
        return new ValueType($characteristic, $model);
    }


    /**
     * @param Product $product
     * @return array|ValueType[]
     */
    public function createTypes(Product $product): array
    {
        $updateValues = [];

        foreach ($product->values as $value) {
            $updateValues[] = $this->createType($value->characteristic, $value);
        }
        return $updateValues;
    }

    /**
     * @param int $productId
     * @param ValueType $type
     * @return Value
     * @throws \yii\base\InvalidConfigException
     */
    public function create(int $productId, ValueType $type): Value
    {
        $value = Value::create($productId, $type->characteristic->id, empty($type->value) ? null : $type->value);
        $this->baseService->save($value);
        return $value;
    }


    /**
     * @param int $productId
     * @param int $characteristicId
     * @return Value
     * @throws \yii\base\InvalidConfigException
     */
    public function blank(int $productId, int $characteristicId): Value
    {
        $value = Value::blank($productId, $characteristicId);
        $this->baseService->save($value);
        return $value;
    }

    /**
     * @param int $productId
     * @param array $types
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function edits(int $productId, array $types)
    {

        $transaction = \Yii::$app->db->beginTransaction();
        try {
            foreach ($types as $type) {
                $this->edit($productId, $type->characteristic->id, empty($type->value) ? null : $type->value);
            }
            $transaction->commit();
        } catch (\Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }

    /**
     * @param int $productId
     * @param $characteristicId
     * @param string|null $value
     * @return Value
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit(int $productId, $characteristicId, string $value = null): Value
    {
        $valueModel = $this->valueRepository->findOneByProductCharacteristic($productId, $characteristicId);
        $this->baseService->notFoundHttpException($valueModel);
        $valueModel->edit($value);
        $this->baseService->save($valueModel);
        return $valueModel;
    }
}