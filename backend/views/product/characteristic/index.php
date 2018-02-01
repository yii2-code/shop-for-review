<?php

/** @var $this \yii\web\View */

use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Url;
use yii\jui\DatePicker;

/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $filterModel \shop\entities\Product\Characteristic[] */

$this->title = 'Characteristic';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <?= $this->title ?>
    <p>
        <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">Create</a>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            ['class' => SerialColumn::class],
            'id',
            'title',
            [
                'attribute' => 'created_at',
                'filter' => DatePicker::widget([
                    'model' => $filterModel,
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
                    'model' => $filterModel,
                    'attribute' => 'updated_at',
                    'dateFormat' => 'php:Y-m-d',
                    'options' => [
                        'class' => 'form-control',
                    ]
                ]),
                'format' => 'datetime',
            ],
            ['class' => ActionColumn::class],
        ]
    ]) ?>
</div>
