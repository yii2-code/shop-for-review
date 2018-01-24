<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 22:56
 */

namespace shop\types\Product;


use shop\entities\Product\Brand;
use yii\base\Model;

class BrandType extends Model
{
    public $title;
    public $description;
    public $status;

    public function __construct(Brand $model, array $config = [])
    {
        parent::__construct($config);
    }
}