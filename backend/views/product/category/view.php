<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 18:52
 */

/** @var $this \yii\web\View */
/** @var $model \shop\entities\Product\Category */

?>

<?= \yii\widgets\DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'title'
    ]
]) ?>
