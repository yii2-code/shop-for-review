<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.02.18
 * Time: 17:49
 */

use yii\widgets\LinkPager;

/** @var $this \yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $parents \shop\entities\Product\Category[] */
/** @var $category \shop\entities\Product\Category */

$this->title = $category->title;

foreach ($parents as $parent) {
    $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/product/category/index', 'id' => $parent->id]];
}

$this->params['breadcrumbs'][] = ['label' => $category->title]

?>
<?php foreach (array_chunk($dataProvider->getModels(), 4) as $models): ?>
    <div class="row">
        <?php foreach ($models as $model): ?>
            <?= $this->render('@frontend/views/parts/product', ['model' => $model]) ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]); ?>