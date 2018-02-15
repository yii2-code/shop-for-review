<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 14:26
 */

use app\modules\image\widgets\ImageWidget;
use app\modules\tag\widgets\TagWidget;
use shop\entities\Product\Product;
use shop\helpers\BrandHelper;
use shop\helpers\CategoryHelper;
use shop\helpers\CharacteristicHelper;
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

    <?= $form->field($type, 'announce')->textarea(['class' => 'wysihtml5 form-control']); ?>

    <?= $form->field($type, 'description')->textarea(['class' => 'wysihtml5 form-control']); ?>

    <?= $form->field($type, 'brandId')->dropDownList(BrandHelper::getDropDown()); ?>

    <?= $form->field($type, 'categoryMainId')->dropDownList(CategoryHelper::getTree()); ?>

    <?= $form->field($type->category, 'categories')->dropDownList(CategoryHelper::getTree(), ['multiple' => true]); ?>

    <?= $form->field($type, 'tags')->widget(TagWidget::class) ?>

    <?= $form->field($type, 'status')->dropDownList(ProductHelper::getStatusDropDown()); ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <?= $form->field($type->price, 'price')->input('number') ?>

            <?= $form->field($type->price, 'oldPrice')->input('number') ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">Characteristics</div>
        <div class="panel-body">
            <?php foreach ($type->values as $index => $value): ?>
                <?php if ($value->characteristic->isDropDownList()): ?>
                    <?= $form->field($value, '[]value', ['enableClientValidation' => false])->dropDownList(CharacteristicHelper::getVariantsDropDown($value->characteristic)) ?>
                <?php else: ?>
                    <?= $form->field($value, '[]value', ['enableClientValidation' => false])->textInput(['value' => $value->characteristic->default]) ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php $form::end() ?>

    <?= ImageWidget::widget(['model' => new Product()]) ?>
</div>


