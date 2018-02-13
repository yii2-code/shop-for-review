<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 13.02.18
 * Time: 18:38
 */

namespace shop\widgets;


use shop\search\product\SearchType;
use yii\base\Widget;

class SearchWidget extends Widget
{
    public function run()
    {
        $type = SearchType::createType();

        return $this->render('search', ['type' => $type]);
    }
}