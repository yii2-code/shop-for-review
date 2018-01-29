<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 29.01.18
 * Time: 17:25
 */

namespace backend\modules\tag\tests\unit\models\tagAssign;


use backend\modules\tag\models\Tag;
use backend\modules\tag\models\TagAssign;
use backend\modules\tag\tests\fixtures\TagFixture;
use backend\modules\tag\tests\UnitTester;
use Codeception\Test\Unit;

/**
 * Class CrateTest
 * @package backend\modules\tag\tests\unit\models\tagAssign
 */
class CrateTest extends Unit
{
    /** @var UnitTester */
    protected $tester;

    /**
     * @group tag
     * @throws \backend\modules\tag\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'tag' => TagFixture::class
        ]);

        /** @var Tag $tag */
        $tag = $this->tester->grabFixture('tag', 1);

        $model = TagAssign::create(static::class, $recordId = 1, $tag->id);
        $this->assertTrue($model->save(), 'Unable to save model');
    }
}