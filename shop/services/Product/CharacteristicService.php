<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 19:32
 */

declare(strict_types=1);

namespace shop\services\Product;


use DomainException;
use shop\entities\Product\Characteristic;
use shop\entities\Product\Variant;
use shop\entities\repositories\Product\CharacteristicRepository;
use shop\services\BaseService;
use shop\types\Product\CharacteristicType;

/**
 * Class CharacteristicService
 * @package shop\services\Product
 */
class CharacteristicService
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var CharacteristicRepository
     */
    private $characteristicRepository;


    /**
     * CharacteristicService constructor.
     * @param BaseService $baseService
     * @param CharacteristicRepository $characteristicRepository
     */
    public function __construct(
        BaseService $baseService,
        CharacteristicRepository $characteristicRepository
    )
    {

        $this->baseService = $baseService;
        $this->characteristicRepository = $characteristicRepository;
    }

    /**
     * @param Characteristic|null $model
     * @return CharacteristicType
     */
    public function createType(Characteristic $model = null): CharacteristicType
    {
        return new CharacteristicType($model);
    }

    /**
     * @param CharacteristicType $type
     * @return Characteristic
     */
    public function create(CharacteristicType $type): Characteristic
    {

        $variant = Variant::findOne($type->type);
        $characteristic = Characteristic::create(
            $type->title,
            $type->type,
            $type->required,
            $this->handleDefault($variant, $type->default),
            $this->handelVariants($variant, $type->variants)
        );

        $this->baseService->save($characteristic);

        return $characteristic;
    }

    /**
     * @param int $id
     * @param CharacteristicType $type
     * @return null|Characteristic
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit(int $id, CharacteristicType $type)
    {
        $characteristic = $this->characteristicRepository->findOne($id);
        $this->baseService->notFoundHttpException($characteristic);

        $variant = $characteristic->getVariant();

        $characteristic->edit(
            $type->title,
            $type->type,
            $type->required,
            $this->handleDefault($variant, $type->default),
            $this->handelVariants($variant, $type->variants)
        );
        $this->baseService->save($characteristic);
        return $characteristic;
    }

    /**
     * @param Variant $variant
     * @param string $default
     * @return mixed
     */
    public function handleDefault(Variant $variant, string $default)
    {
        if (empty($default)) {
            return null;
        }
        if (!$variant->validate($default)) {
            throw new DomainException('default must be set as ' . $variant->name);
        }
        return $variant->cast($default);
    }

    /**
     * @param Variant $type
     * @param $variants
     * @return array
     */
    public function handelVariants(Variant $type, $variants): array
    {
        if (empty($variants) || !is_array($variants)) {
            return [];
        }
        $variants = array_filter($variants);
        foreach ($variants as &$variant) {
            if (!$type->validate($variant)) {
                throw new DomainException(sprintf('variant "%s" must be set as %s', $variant, $type->name));
            }
            $variant = $type->cast($variant);
        }
        return $variants;
    }
}