<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 29.01.18
 * Time: 17:26
 */

namespace backend\modules\tag\tests\fixtures;


use backend\modules\tag\models\Tag;
use yii\test\ActiveFixture;

class TagFixture extends ActiveFixture
{
    public function __construct(array $config = [])
    {
        $this->modelClass = Tag::class;
        $this->dataFile = codecept_data_dir('tag.php');
        parent::__construct($config);
    }

}