<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 12.02.18
 * Time: 22:58
 */

use shop\entities\Auth\Profile;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

/** @var $this \yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $filterModel \shop\search\auth\ProfileSearch */

$this->title = 'Profile';

$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            ['class' => SerialColumn::class],
            'id',
            [
                'attribute' => 'login',
                'value' => function (Profile $model) {
                    return ArrayHelper::getValue($model, ['user', 'login']);
                },
            ],
            'first_name',
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
            [
                'class' => ActionColumn::class,
                'template' => '{view} {update}'
            ]
        ]
    ]) ?>
</div>



