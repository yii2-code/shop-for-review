<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.02.18
 * Time: 16:20
 */

/** @var $this \yii\web\View */
/** @var $models \shop\entities\Product\Product[] */
/** @var $list array */

?>

<?php foreach ($list as $models): ?>
    <div class="row">
        <?php foreach ($models as $model): ?>
            <?= $this->render('@frontend/views/parts/product', ['model' => $model]) ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
