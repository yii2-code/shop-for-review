<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 13.02.18
 * Time: 20:54
 */

namespace shop\search\product;

use shop\entities\Product\Characteristic;
use yii\base\Model;

/**
 * Class CharacteristicSearch
 * @package shop\search\product
 */
class ValueSearch extends Model
{
    /**
     * @var
     */
    public $equal;
    /**
     * @var
     */
    public $from;

    /**
     * @var
     */
    public $to;

    /**
     * @var Characteristic
     */
    public $characteristic;

    /**
     * CharacteristicSearch constructor.
     * @param Characteristic $characteristic
     * @param array $config
     */
    public function __construct(Characteristic $characteristic, $config = [])
    {
        parent::__construct($config);
        $this->characteristic = $characteristic;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [$this->characteristic->getVariant()->search];
    }

    /**
     * @return bool
     */
    public function isFill(): bool
    {
        return !empty($this->equal) || !empty($this->from) || !empty($this->to);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->characteristic->id;
    }

    /**
     * @return string
     */
    public function formName()
    {
        return 'v';
    }
}