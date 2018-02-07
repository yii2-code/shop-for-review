<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 07.02.18
 * Time: 16:25
 */

namespace common\fixtures;


use app\modules\image\models\Image;
use yii\test\ActiveFixture;

class ImageFixture extends ActiveFixture
{
    public function __construct(array $config = [])
    {
        $this->modelClass = Image::class;
        $this->dataFile = __DIR__ . '/data/image.php';
        parent::__construct($config);
    }
}