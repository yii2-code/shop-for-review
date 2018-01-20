<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 19:38
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Auth\ResetPasswordType */

?>

<div class="row">
    <div class="col-lg-5">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($type, 'password')->passwordInput(['autofocus' => true]) ?>

        <?= $form->field($type, 'repeatPassword')->passwordInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
