<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 13:55
 */

use shop\entities\Product\Product;
use shop\helpers\BrandHelper;
use shop\helpers\CategoryHelper;
use shop\helpers\ProductHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Url;
use yii\jui\DatePicker;

/** @var $this \yii\web\View */
/** @var $searchModel \shop\search\ProductSearch */
/** @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Product';

$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>

    <p><a href="<?= Url::to(['create']) ?>" class="btn btn-primary">Create</a></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => SerialColumn::class],
            'id',
            'title',
            [
                'attribute' => 'brand_id',
                'filter' => BrandHelper::getDropDown(),
                'value' => function (Product $model) {
                    return $model->brand->title;
                }
            ],
            [
                'attribute' => 'category_main_id',
                'filter' => CategoryHelper::getTree(),
                'value' => function (Product $model) {
                    return $model->categoryMain->title;
                }
            ],
            [
                'attribute' => 'status',
                'filter' => ProductHelper::getStatusDropDown(),
                'value' => function (Product $model) {
                    return $model->getStatus();
                }
            ],
            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'created_at',
                    'dateFormat' => 'php:Y-m-d',
                    'options' => [
                        'class' => 'form-control',
                    ]
                ]),
                'format' => 'datetime',
            ],
            [
                'attribute' => 'updated_at',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'updated_at',
                    'dateFormat' => 'php:Y-m-d',
                    'options' => [
                        'class' => 'form-control',
                    ]
                ]),
                'format' => 'datetime',
            ],
            ['class' => ActionColumn::class]
        ],
    ]) ?>
</div>
