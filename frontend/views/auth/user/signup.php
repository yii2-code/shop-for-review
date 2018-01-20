<?php

/* @var $this yii\web\View */

/** @var $type \shop\types\Auth\SignupType */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($type, 'login')->textInput(['autofocus' => true]) ?>

        <?= $form->field($type, 'email') ?>

        <?= $form->field($type, 'password')->passwordInput() ?>

        <?= $form->field($type, 'repeatPassword')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

