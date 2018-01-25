<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 16:57
 */

use shop\entities\Product\Brand;
use yii\widgets\DetailView;

/** @var $model Brand */
/** @var $this \yii\web\View */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Brand', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Update', 'url' => ['update', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>

    <h1><?= $this->title ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'description',
            [
                'attribute' => 'status',
                'value' => function (Brand $model) {
                    return $model->getStatus();
                }
            ],
            'created_at:datetime',
            'updated_at:datetime'
        ]
    ]) ?>
</div>


