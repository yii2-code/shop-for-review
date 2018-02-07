<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 16:48
 */

use shop\helpers\BrandHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Product\BrandType */

?>

<?php $form = ActiveForm::begin() ?>

<?= $form->field($type, 'title')->textInput() ?>

<?= $form->field($type, 'description')->textarea(['class' => 'wysihtml5 form-control']) ?>

<?= $form->field($type, 'status')->dropDownList(BrandHelper::getStatusDropDown()) ?>

<div class="form-group">
    <?= Html::submitButton($type->model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
</div>

<?php $form::end() ?>
