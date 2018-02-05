<?php

/* @var $this yii\web\View */

/** @var $type \shop\types\Auth\SignupType */

use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

$this->title = Yii::t('auth', 'Sign up a new membership');
?>
<div class="register-box" style="margin-top: 0px; width: 50%">
    <div class="register-box-body">
        <p class="login-box-msg"><?= $this->title ?></p>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field(
            $type,
            'login',
            [
                'options' => ['class' => 'form-group has-feedback'],
                'template' => "{input}<span class='glyphicon glyphicon-user form-control-feedback'></span>\n{error}"
            ]
        )->textInput(['autofocus' => true, 'placeholder' => 'Login']) ?>

        <?= $form->field(
            $type,
            'email',
            [
                'options' => ['class' => 'form-group has-feedback'],
                'template' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>\n{error}"
            ]
        )->input('email', ['placeholder' => 'Email']); ?>

        <?= $form->field(
            $type,
            'password',
            [
                'options' => ['class' => 'form-group has-feedback'],
                'template' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>\n{error}"
            ]
        )->passwordInput(['placeholder' => 'Password']) ?>
        <?= $form->field(
            $type,
            'repeatPassword',
            [
                'options' => ['class' => 'form-group has-feedback'],
                'template' => "{input}<span class='glyphicon glyphicon-log-in form-control-feedback'></span>\n{error}"
            ]
        )->passwordInput(['placeholder' => 'Retype password']) ?>

        <div class="row">
            <div class="col-xs-8">
                <!--                    <div class="checkbox icheck">
                                        <label>
                                            <input type="checkbox"> I agree to the <a href="#">terms</a>
                                        </label>
                                    </div>-->
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign up', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
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

        <a href="<?= Url::to(['/sign-in']) ?>"
           class="text-center"><?= Yii::t('auth', 'I already have a membership') ?></a>
    </div>
</div>