<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 16:35
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/** @var $type \shop\types\Auth\SignInType */
/* @var $this yii\web\View */

?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($type, 'login')->textInput(['autofocus' => true]) ?>

        <?= $form->field($type, 'password')->passwordInput() ?>

        <div style="color:#999;margin:1em 0">
            If you forgot your password you can <?= Html::a('reset it', ['/request']) ?>.
        </div>

        <div class="form-group">
            <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>