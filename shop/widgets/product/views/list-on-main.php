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
            <div class="col-md-3">
                <div class="thumbnail">
                    <img src="<?= $model->getMainImageDto()->getUrlThumb('340x250') ?>" class="img-responsive">
                    <div class="caption">
                        <p><?= $model->announce ?></p>
                        <div class="btn-group">
                            <button type="button" class="btn btn-sm">View</button>
                            <button type="button" class="btn btn-sm">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
