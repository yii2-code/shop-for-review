<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 23:20
 */

declare(strict_types=1);

namespace shop\entities\Product;

use yii\base\Object;
use yii\helpers\ArrayHelper;


/**
 * Class Variant
 * @package shop\entities\Product
 */
class Variant extends Object
{
    /**
     * @var
     */
    public $id;
    /**
     * @var
     */
    public $name;
    /**
     * @var
     */
    public $cast;
    /**
     * @var
     */
    public $validator;

    /**
     *
     */
    const TYPE_STRING = 1;

    /**
     *
     */
    const TYPE_INTEGER = 2;

    /**
     *
     */
    const TYPE_FLOAT = 3;

    /**
     * @var array
     */
    public static $variants = [
        '1' => [
            'id' => 1,
            'name' => 'String',
            'cast' => 'strval',
            'validator' => 'is_string',
        ],
        '2' => [
            'id' => 2,
            'name' => 'Number',
            'cast' => 'intval',
            'validator' => 'is_numeric',
        ],
        '3' => [
            'id' => 3,
            'name' => 'Float',
            'cast' => 'floatval',
            'validator' => 'is_numeric',
        ],
    ];


    /**
     * @param int $id
     * @return null|Variant
     */
    public static function findOne(int $id): ?self
    {
        return static::$variants[$id] ? new static(static::$variants[$id]) : null;
    }


    /**
     * @return array
     */
    public static function getDropDown(): array
    {
        return ArrayHelper::map(static::$variants, 'id', 'name');
    }

    /**
     * @param $value
     * @return mixed
     */
    public function cast($value)
    {
        $cast = $this->cast;
        return $cast($value);
    }


    /**
     * @param $value
     * @return bool
     */
    public function validate($value): bool
    {
        $validator = $this->validator;
        return $validator($value);
    }
}