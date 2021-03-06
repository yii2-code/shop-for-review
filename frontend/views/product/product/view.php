<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 12.02.18
 * Time: 21:45
 */

use yii\helpers\ArrayHelper;

/** @var $this \yii\web\View */
/** @var $model \shop\entities\Product\Product */
/** @var $parents \shop\entities\Product\Category */

$this->title = $model->title;

foreach ($parents as $parent) {
    $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/product/category/index', 'id' => $parent->id]];
}
$this->params['breadcrumbs'][] = ['label' => $model->categoryMain->title, 'url' => ['/product/category/index', 'id' => $model->categoryMain->id]];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

    <div class="col-md-10">
        <div class="row">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->

                <ol class="carousel-indicators">
                    <?php foreach ($model->getImagesDto() as $index => $image): ?>
                        <li data-target="#carousel-example-generic" data-slide-to="<?= $index ?>"
                            class="<?= $index == 0 ? 'active' : null; ?>"></li>
                    <?php endforeach; ?>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <?php foreach ($model->getImagesDto() as $index => $image): ?>
                        <div class="item<?= $index == 0 ? ' active' : null; ?>">
                            <img src="<?= $image->getUrlSrc() ?>">
                        </div>
                    <?php endforeach; ?>
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
        </div>
        <br>
        <div class="row">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Specification</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <?php foreach ($model->values as $value): ?>
                            <?php if (!empty($value->value)): ?>
                                <p><?= $value->characteristic->title ?>: <?= $value->value ?></p>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- /.tab-content -->
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <p>Brand: <?= $model->brand->title ?></p>
        <p>Category: <?= $model->categoryMain->title ?></p>
        <?php if (!empty($model->categories)): ?>
            <p>Additional Category: <?= implode(',', ArrayHelper::getColumn($model->categories, 'title')) ?></p>
        <?php endif; ?>
        <p>Price: <?= Yii::$app->formatter->asCurrency($model->price) ?></p>
        <p>Old price: <?= Yii::$app->formatter->asCurrency($model->old_price) ?></p>
    </div>
