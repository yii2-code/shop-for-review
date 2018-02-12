<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 11.02.18
 * Time: 22:06
 */

use shop\entities\Auth\User;
use shop\helpers\UserHelper;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Url;
use yii\jui\DatePicker;

/** @var $this \yii\web\View */
/** @var $filterModel \shop\search\auth\UserSearch */
/** @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'User';

?>

<div>
    <h1><?= $this->title ?></h1>
    <p>
        <a href="<?= Url::to(['create']) ?>" class="btn btn-primary"><?= Yii::t('backend', 'Create') ?></a>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $filterModel,
        'columns' => [
            ['class' => SerialColumn::class],
            'id',
            'login',
            'email',
            [
                'attribute' => 'status',
                'filter' => UserHelper::getStatusDropDown(),
                'value' => function (User $model) {
                    return $model->getStatus();
                }
            ],
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
            ['class' => ActionColumn::class,]
        ]
    ]) ?>
</div>
