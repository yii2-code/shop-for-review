<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 18:34
 */

/** @var $this \yii\web\View */
/** @var $images array */
/** @var $warning string */

?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php if (isset($warning)) : ?>
            <div class="alert alert-warning"><?= $warning ?></div>
        <?php endif; ?>
        <?php foreach ($images as $row) : ?>
            <div class="row">
                <?php foreach ($row as $image): ?>
                    <?php /**@var $image \backend\modules\image\TDO\ImageTdo */ ?>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <img src="<?= $image->getUrlSrc() ?>" alt="">

                            <div class="caption">

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>