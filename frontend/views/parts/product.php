<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.02.18
 * Time: 17:51
 */

use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $model \shop\entities\Product\Product */

?>

<div class="col-md-3">
    <div class="thumbnail">
        <img src="<?= $model->getMainImageDto()->getUrlThumb('340x250') ?>" class="img-responsive">
        <div class="caption">
            <p><?= $model->announce ?></p>
            <div class="btn-group">
                <a href="<?= Url::to(['/product/product/view', 'id' => $model->id]) ?>" class="btn btn-sm btn-success">View</a>
            </div>
        </div>
    </div>
</div>
