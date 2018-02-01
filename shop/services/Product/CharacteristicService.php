<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 19:32
 */

declare(strict_types=1);

namespace shop\services\Product;


use shop\entities\Product\Characteristic;
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
        $characteristic = Characteristic::create(
            $type->title,
            $type->type,
            $type->required,
            empty($type->default) ? null : $type->default,
            $this->filterVariants($type->variants)
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
        $characteristic->edit(
            $type->title,
            $type->type,
            $type->required,
            empty($type->default) ? null : $type->default,
            $this->filterVariants($type->variants)
        );
        $this->baseService->save($characteristic);
        return $characteristic;
    }

    /**
     * @param $variants
     * @return array
     */
    public function filterVariants($variants): array
    {
        if (empty($variants) || !is_array($variants)) {
            return [];
        }
        return array_filter($variants);
    }
}