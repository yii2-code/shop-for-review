<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 13:54
 */

namespace app\modules\tag\tests\fixtures;


use app\modules\tag\models\TagAssign;
use yii\test\ActiveFixture;

/**
 * Class TagAssignFixture
 * @package app\modules\tag\tests\fixtures
 */
class TagAssignFixture extends ActiveFixture
{
    /**
     * TagAssignFixture constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->modelClass = TagAssign::class;
        $this->dataFile = codecept_data_dir('tag_assign.php');
        parent::__construct($config);
    }
}