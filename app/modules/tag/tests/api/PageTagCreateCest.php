<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 20:54
 */

namespace app\modules\tag\tests\api;


use app\modules\tag\tests\ApiTester;

/**
 * Class PageTagCreateCest
 * @package app\modules\tag\tests\api
 */
class PageTagCreateCest
{
    /**
     * @group tag
     * @param ApiTester $tester
     */
    public function createPage(ApiTester $tester)
    {
        $tester->sendPOST('?r=tag/tag/create', ['tag' => 'test']);
        $tester->seeResponseCodeIs(200);
        $tester->seeResponseIsJson();
        $tester->seeResponseContainsJson(['status' => 'ok']);
    }
}