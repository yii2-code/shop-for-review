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

/**
 * Class BrandType
 * @package shop\types\Product
 */
class BrandType extends Model
{
    /**
     * @var
     */
    public $title;
    /**
     * @var
     */
    public $description;
    /**
     * @var
     */
    public $status;
    /**
     * @var Brand
     */
    public $model;

    /**
     * BrandType constructor.
     * @param Brand|null $model
     * @param array $config
     */
    public function __construct(Brand $model = null, array $config = [])
    {
        if (!is_null($model) && !$model->isNewRecord) {
            $this->title = $model->title;
            $this->description = $model->description;
            $this->status = $model->status;
            $this->model = $model;
        } else {
            $this->model = new Brand();
        }

        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'description', 'status'], 'required'],
            ['title', 'string', 'max' => 512],
            ['description', 'string'],
            ['status', 'integer'],
            ['status', 'filter', 'filter' => 'intval']
        ];
    }

}