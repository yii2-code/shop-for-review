<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 18:52
 */

use shop\entities\Product\Category;
use yii\widgets\DetailView;

/** @var $this \yii\web\View */
/** @var $model Category */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Category', 'url' => ['index']];
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
            'description:html',
            [
                'attribute' => 'status',
                'value' => function (Category $model) {
                    return $model->getStatus();
                }
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ]
    ]) ?>
</div>

