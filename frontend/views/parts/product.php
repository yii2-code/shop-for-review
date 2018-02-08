<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.02.18
 * Time: 17:51
 */

/** @var $this \yii\web\View */
/** @var $model \shop\entities\Product\Product */

?>

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
