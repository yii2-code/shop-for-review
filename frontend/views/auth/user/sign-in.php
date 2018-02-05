<?php

use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/** @var $type \shop\types\Auth\SignInType */
/* @var $this yii\web\View */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b>LTE</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($type, 'login', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $type->getAttributeLabel('login')]) ?>

        <?= $form
            ->field($type, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $type->getAttributeLabel('password')]) ?>

        <div class="row">
            <!--            <div class="col-xs-8">
                <? /*= $form->field($type, 'rememberMe')->checkbox() */ ?>
            </div>-->
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <?php $authAuthChoice = AuthChoice::begin([
                'baseAuthUrl' => ['/oauth'],
                'popupMode' => false,
            ]); ?>

            <?php foreach ($authAuthChoice->getClients() as $client): ?>
                <a href="<?= $authAuthChoice->createClientUrl($client) ?>"
                   class="btn btn-block btn-social btn-<?= $client->getName() ?> btn-flat"><i
                            class="fa fa-<?= $client->getName() ?>"></i><?= $client->getTitle() ?></a>
            <?php endforeach; ?>
            <?php AuthChoice::end(); ?>
        </div>
        <!-- /.social-auth-links -->

        <a href="<?= Url::to('/request-reset') ?>"><?= Yii::t('auth', 'I forgot my password') ?></a><br>
        <a href="<?= Url::to(['/signup']) ?>" class="text-center"><?= Yii::t('auth', 'Sign up a new membership') ?></a>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
