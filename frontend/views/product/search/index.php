<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 13.02.18
 * Time: 18:32
 */

use shop\helpers\BrandHelper;
use shop\helpers\CategoryHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/** @var $this \yii\web\View */
/** @var $type \shop\search\product\SearchType */
/** @var $dataProvider \yii\data\ActiveDataProvider */

$this->title = 'Search';

$this->params['breadcrumbs'][] = ['label' => $this->title]

?>

<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['action' => [''], 'method' => 'get']); ?>

        <?= $form->field($type, 'keywords') ?>

        <?= $form->field($type, 'brandId')->dropDownList(['' => ''] + BrandHelper::getDropDown()) ?>

        <?= $form->field($type, 'categoryId')->dropDownList(['' => ''] + CategoryHelper::getTree()) ?>

        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Reset', [''], ['class' => 'btn btn-success']) ?>
        </div>
        <?php $form::end() ?>
    </div>
</div>

<?php foreach (array_chunk($dataProvider->getModels(), 4) as $models): ?>
    <div class="row">
        <?php foreach ($models as $model): ?>
            <?= $this->render('@frontend/views/parts/product', ['model' => $model]) ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]); ?>
