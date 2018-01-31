<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 13:51
 */

namespace app\modules\tag\tests\unit\services\TagAssign;


use app\modules\tag\models\Tag;
use app\modules\tag\models\TagAssign;
use app\modules\tag\tests\fixtures\TagAssignFixture;
use app\modules\tag\tests\fixtures\TagFixture;

/**
 * Class AssignTest
 * @package app\modules\tag\tests\unit\services\TagAssign
 */
class AssignTest extends Unit
{

    /**
     * @group tag
     * @throws \app\modules\tag\tests\_generated\ModuleException
     */
    public function testSuccess()
    {
        $this->tester->haveFixtures([
            'tag' => TagFixture::class,
            'tag_assign' => TagAssignFixture::class,
        ]);

        /** @var Tag $tag1 */
        $tag1 = $this->tester->grabFixture('tag', 1);
        /** @var Tag $tag2 */
        $tag2 = $this->tester->grabFixture('tag', 4);

        $this->service->assign(TagAssignFixture::class, 1, [$tag1->name, $tag2->name]);

        $this->tester->seeRecord(
            TagAssign::class,
            [
                'class' => TagAssignFixture::class,
                'record_id' => 1,
                'tag_id' => $tag1->id,
            ]
        );

        $this->tester->seeRecord(
            TagAssign::class,
            [
                'class' => TagAssignFixture::class,
                'record_id' => 1,
                'tag_id' => $tag2->id,
            ]
        );

        /** @var Tag $tag1 */
        $tag3 = $this->tester->grabFixture('tag', 2);
        /** @var Tag $tag2 */
        $tag4 = $this->tester->grabFixture('tag', 3);

        $this->tester->dontSeeRecord(
            TagAssign::class,
            [
                'class' => TagAssignFixture::class,
                'record_id' => 1,
                'tag_id' => $tag3->id,
            ]
        );

        $this->tester->dontSeeRecord(
            TagAssign::class,
            [
                'class' => TagAssignFixture::class,
                'record_id' => 1,
                'tag_id' => $tag4->id,
            ]
        );
    }
}