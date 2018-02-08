<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 07.02.18
 * Time: 19:09
 */

/** @var $this \yii\web\View */
/** @var $models \shop\entities\Product\Product[] */

?>


<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <?php foreach ($models as $index => $model): ?>
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic"
                data-slide-to="<?= $index ?>" <?= $index == 0 ? 'class="active"' : null ?>></li>
        </ol>
    <?php endforeach; ?>

    <div class="row">
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <?php foreach ($models as $index => $model): ?>
                <div class="item<?= $index == 0 ? ' active' : null ?>">
                    <img src="<?= $model->getMainImageDto()->getUrlThumb('1000x400') ?>" class="img-responsive"
                         alt="...">
                    <div class="carousel-caption">
                        First
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>




