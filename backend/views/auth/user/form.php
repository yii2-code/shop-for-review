<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 11.02.18
 * Time: 23:26
 */

use shop\helpers\UserHelper;
use shop\types\Auth\UserType;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $type UserType */

?>

<div>
    <?php $form = ActiveForm::begin() ?>

    <?= $form->field($type, 'login') ?>

    <?= $form->field($type, 'email') ?>

    <?= $form->field($type, 'password') ?>

    <?= $form->field($type, 'status')->dropDownList(UserHelper::getStatusDropDown()) ?>

    <div class="form-group">
        <?= Html::submitButton(
            $type->model->isNewRecord ? Yii::t('backend', 'Create') : Yii::t('yii', 'Update'),
            ['class' => 'btn btn-primary']
        ) ?>
    </div>

    <?php $form::end() ?>
</div>
