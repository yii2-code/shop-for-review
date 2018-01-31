<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 28.01.18
 * Time: 14:08
 */

namespace app\modules\image\types;


use app\modules\image\models\Image;
use yii\base\Model;

/**
 * Class ImageUpdateType
 * @package app\modules\image\types
 */
class UpdateType extends Model
{
    /**
     * @var
     */
    public $name;


    /**
     * @var Image
     */
    public $model;

    /**
     * UpdateType constructor.
     * @param Image|null $model
     * @param array $config
     */
    public function __construct(Image $model = null, array $config = [])
    {
        parent::__construct($config);
        if (!is_null($model)) {
            $this->name = $model->name;
            $this->model = $model;
        } else {
            $this->model = new Image();
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['name', 'string', 'max' => 100],
        ];
    }
}