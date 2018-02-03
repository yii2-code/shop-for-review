<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 15:34
 */

use app\modules\image\widgets\ImageWidget;
use shop\helpers\CategoryHelper;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var $this \yii\web\View */
/** @var $model \shop\entities\Product\Product */
/** @var $type \shop\types\Product\PriceType */
/** @var $updateValues \shop\types\Product\ValueType[] */
/** @var $categoryType \shop\types\Product\CategoryAssignType */

$this->title = $model->title;

$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>

    <div class="btn-group" role="group" style="margin-bottom: 15px">
        <a href="<?= Url::to(['update', 'id' => $model->id]) ?>" class="btn btn-primary">Update</a>
        <?php Modal::begin([
            'toggleButton' => ['label' => 'Update price', 'class' => 'btn btn-primary btn-right'],
        ]) ?>
        <?php $form = ActiveForm::begin(['action' => ['edit-price', 'id' => $model->id]]) ?>

        <?= $form->field($type, 'price')->input('number') ?>

        <?= $form->field($type, 'oldPrice')->input('number') ?>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php $form::end() ?>
        <?php Modal::end() ?>
        <?php Modal::begin([
            'toggleButton' => ['label' => 'Update Characteristics', 'class' => 'btn btn-primary btn-right'],
        ]) ?>
        <?php $form = ActiveForm::begin(['action' => ['edit-value', 'id' => $model->id]]) ?>

        <?php foreach ($updateValues as $value): ?>

            <?php if ($value->characteristic->isDropDownList()): ?>
                <?= $form->field($value, '[]value', ['enableClientValidation' => false])->dropDownList($value->getDropDownList()) ?>
            <?php else: ?>
                <?= $form->field($value, '[]value', ['enableClientValidation' => false])->textInput() ?>
            <?php endif; ?>

        <?php endforeach; ?>
        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php $form::end() ?>
        <?php Modal::end() ?>
        <?php Modal::begin([
            'toggleButton' => ['label' => 'Update other Categories', 'class' => 'btn btn-primary btn-right'],
        ]) ?>
        <?php $form = ActiveForm::begin(['action' => ['edit-category', 'id' => $model->id]]) ?>

        <?= $form->field($categoryType, 'categories')->dropDownList(CategoryHelper::getTree(), ['multiple' => true]); ?>

        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php $form::end() ?>
        <?php Modal::end() ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'announce',
            'description',
            'price',
            'old_price',
            [
                'attribute' => 'brand_id',
                'value' => $model->brand->title,
            ],
            [
                'attribute' => 'catalog_main_id',
                'value' => $model->categoryMain->title,
            ],
            [
                'attribute' => 'status',
                'value' => $model->getStatus(),
            ],
            'created_at:datetime',
            'updated_at:datetime'
        ]
    ]) ?>

    <?= ImageWidget::widget(['model' => $model]) ?>
</div>
