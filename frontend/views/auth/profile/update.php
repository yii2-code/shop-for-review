<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 14:51
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Auth\ProfileType */

$this->title = 'Update profile'

?>

<div>
    <h1><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($type, 'firstName')->textInput() ?>

    <?= $form->field($type, 'middleName')->textInput() ?>

    <?= $form->field($type, 'lastName')->textInput() ?>

    <?= $form->field($type, 'about')->textarea() ?>

    <?= $form->field($type, 'src')->fileInput() ?>

    <div class="form">
        <?= Html::submitButton('Update', ['class' => 'btn btn-primary']); ?>
    </div>
    <?php $form::end(); ?>
</div>
