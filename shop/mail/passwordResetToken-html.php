<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \shop\entities\Auth\User */

$emailLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->request_email_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->login) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($emailLink), $emailLink) ?></p>
</div>
