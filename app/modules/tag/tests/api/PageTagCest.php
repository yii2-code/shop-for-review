<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 20:54
 */

namespace app\modules\tag\tests\api;


use app\modules\tag\models\Tag;
use app\modules\tag\tests\ApiTester;
use app\modules\tag\tests\fixtures\TagFixture;
use Yii;

/**
 * Class PageTagCreateCest
 * @package app\modules\tag\tests\api
 */
class PageTagCest
{
    /**
     * @group tag
     * @param ApiTester $tester
     */
    public function createPage(ApiTester $tester)
    {
        $tester->sendPOST(Yii::$app->urlManager->createUrl('/tag/tag/create'), ['tag' => 'test']);
        $tester->seeResponseCodeIs(200);
        $tester->seeResponseIsJson();
        $tester->seeResponseContainsJson(['status' => 'ok']);
    }

    /**
     * @group tag
     * @param ApiTester $tester
     * @throws \app\modules\tag\tests\_generated\ModuleException
     */
    public function viewPage(ApiTester $tester)
    {
        $tester->haveFixtures([
            'tag' => TagFixture::class,
        ]);

        /** @var Tag $tag */
        $tag = $tester->grabFixture('tag', 1);

        $tester->sendGET(Yii::$app->urlManager->createUrl(['/tag/tag/view']));
        $tester->seeResponseCodeIs(200);
        $tester->seeResponseIsJson();
        $tester->seeResponseContainsJson(['id' => $tag->id, 'name' => $tag->name]);
    }
}