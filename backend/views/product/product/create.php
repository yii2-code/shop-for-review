<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 14:26
 */

use backend\modules\image\widgets\ImageWidget;
use shop\entities\Product\Product;
use shop\helpers\BrandHelper;
use shop\helpers\CategoryHelper;
use shop\helpers\ProductHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Product\ProductCreateType */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($type, 'title')->textInput(); ?>

    <?= $form->field($type, 'announce')->textarea(); ?>

    <?= $form->field($type, 'description')->textarea(); ?>

    <?= $form->field($type, 'brandId')->dropDownList(BrandHelper::getDropDown()); ?>

    <?= $form->field($type, 'categoryMainId')->dropDownList(CategoryHelper::getTree()); ?>

    <?= $form->field($type, 'status')->dropDownList(ProductHelper::getStatusDropDown()); ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $form->field($type->price, 'price')->input('number') ?>

            <?= $form->field($type->price, 'oldPrice')->input('number') ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php $form::end() ?>

    <?= ImageWidget::widget(['model' => new Product()]) ?>
</div>

