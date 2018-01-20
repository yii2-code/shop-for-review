<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 19:21
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Auth\RequestPasswordResetType */

?>

<div class="col-lg-5">
    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

    <?= $form->field($type, 'email')->textInput(['autofocus' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Send', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
