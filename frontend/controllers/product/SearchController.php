<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 13.02.18
 * Time: 18:28
 */

namespace frontend\controllers\product;


use shop\search\product\SearchType;
use Yii;
use yii\web\Controller;

class SearchController extends Controller
{
    public function actionIndex()
    {
        $type = SearchType::createType();
        $dataProvider = $type->search(Yii::$app->request->queryParams);

        return $this->render('index', ['type' => $type, 'dataProvider' => $dataProvider]);
    }
}