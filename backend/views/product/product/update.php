<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 16:59
 */

use app\modules\tag\widgets\TagWidget;
use shop\helpers\BrandHelper;
use shop\helpers\CategoryHelper;
use shop\helpers\ProductHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Product\ProductEditType */

$this->title = $type->model->title;

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

    <?= $form->field($type, 'tags')->widget(TagWidget::class) ?>

    <?= $form->field($type, 'status')->dropDownList(ProductHelper::getStatusDropDown()); ?>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php $form::end() ?>
</div>
