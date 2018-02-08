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

?>

<?php foreach (array_chunk($dataProvider->getModels(), 4) as $models): ?>
    <div class="row">
        <?php foreach ($models as $model): ?>
            <?= $this->render('@frontend/views/parts/product', ['model' => $model]) ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]); ?>