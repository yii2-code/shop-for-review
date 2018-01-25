<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 20:11
 */

use shop\helpers\CategoryHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Product\CategoryType */

?>

<?php $form = ActiveForm::begin() ?>
<?= $form->field($type, 'title')->textInput() ?>
<?= $form->field($type, 'description')->textarea() ?>
<?= $form->field($type, 'status')->dropDownList(CategoryHelper::getStatusDropDown()) ?>
<?= $form->field($type, 'categoryId')->dropDownList(['' => ''] + CategoryHelper::getTree()) ?>
<div class="form-group">
    <?= Html::submitButton($type->model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
</div>
<?php $form::end(); ?>
