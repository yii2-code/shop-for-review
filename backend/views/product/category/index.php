<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 17:20
 */

use shop\entities\Product\Category;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\grid\SerialColumn;
use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $models Category[] */

$this->title = 'Category';
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>

    <p>
        <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">Create</a>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => SerialColumn::class],
            'id',
            [
                'attribute' => 'title',
                'value' => function (Category $model) {
                    return str_repeat('-', $model->depth - 1) . $model->title;
                },
            ],
            [
                'attribute' => 'status',
                'value' => function (Category $model) {
                    return $model->getStatus();
                },
            ],
            ['class' => ActionColumn::class],
        ]
    ]) ?>
</div>


