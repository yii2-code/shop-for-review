<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 15:07
 */

use shop\entities\Product\Brand;
use shop\helpers\BrandHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Url;
use yii\jui\DatePicker;

/** @var $this \yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $modelSearch \shop\search\product\BrandSearch */

$this->title = 'Brand';

$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>

    <p>
        <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">Create</a>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $modelSearch,
        'columns' => [
            ['class' => SerialColumn::class],
            'id',
            'title',
            [
                'attribute' => 'status',
                'filter' => BrandHelper::getStatusDropDown(),
                'value' => function (Brand $model) {
                    return $model->getStatus();
                },
            ],
            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'model' => $modelSearch,
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
                    'model' => $modelSearch,
                    'attribute' => 'updated_at',
                    'dateFormat' => 'php:Y-m-d',
                    'options' => [
                        'class' => 'form-control',
                    ]
                ]),
                'format' => 'datetime',
            ],
            ['class' => ActionColumn::class]
        ]
    ]) ?>
</div>
