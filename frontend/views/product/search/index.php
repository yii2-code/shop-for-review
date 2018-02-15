<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 13.02.18
 * Time: 18:32
 */

use shop\helpers\BrandHelper;
use shop\helpers\CategoryHelper;
use shop\helpers\CharacteristicHelper;
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

        <?= $form->field($type, 'keywords')->textInput() ?>

        <?= $form->field($type, 'brandId')->dropDownList(['' => ''] + BrandHelper::getDropDown()) ?>

        <?= $form->field($type, 'categoryId')->dropDownList(['' => ''] + CategoryHelper::getTree()) ?>

        <?php foreach ($type->values as $index => $value): ?>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <?= $value->characteristic->title ?>
                    </div>
                </div>
                <?php if ($value->characteristic->isNumber()): ?>
                    <div class="col-md-5 form-horizontal">
                        <?= $form->field(
                            $value,
                            '[' . $index . ']from',
                            [
                                'template' => "{label}\n<div class='col-md-11'>{input}</div>\n{hint}\n{error}"
                            ]
                        )->textInput()->label(null, ['class' => 'control-label col-md-1'])
                        ?>
                    </div>
                    <div class="col-md-5 form-horizontal">
                        <?= $form->field(
                            $value,
                            '[' . $index . ']to',
                            [
                                'template' => "{label}\n<div class='col-md-11'>{input}</div>\n{hint}\n{error}"
                            ]
                        )->textInput()->label(null, ['class' => 'control-label col-md-1'])
                        ?>
                    </div>

                <?php else: ?>
                    <div class="col-md-10 form-inlie">
                        <?php if ($value->characteristic->isDropDownList()): ?>
                            <?= $form->field($value, '[' . $index . ']equal')->dropDownList(['' => ''] + CharacteristicHelper::getVariantsDropDown($value->characteristic))->label(false) ?>
                        <?php else: ?>
                            <?= $form->field($value, '[' . $index . ']equal')->textInput()->label(false) ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
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
