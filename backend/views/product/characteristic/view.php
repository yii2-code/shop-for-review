<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 18:52
 */

use shop\entities\Product\Characteristic;
use yii\widgets\DetailView;

/** @var $this \yii\web\View */
/** @var $model Characteristic */

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
            [
                'attribute' => 'type',
                'value' => $model->getType(),

            ],
            [
                'attribute' => 'required',
                'value' => $model->getRequired(),
            ],
            'default',
            [
                'attribute' => 'variants',
                'value' => implode(',', $model->variants)
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ]
    ]) ?>
</div>