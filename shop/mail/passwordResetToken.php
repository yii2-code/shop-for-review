<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \shop\entities\Auth\User */

$emailLink = Yii::$app->urlManager->createAbsoluteUrl(['/auth/password-reset/reset', 'token' => $user->password_reset_token]);
?>
<div class="password-reset">
    <p><?= Yii::t('auth', 'Hello {login}', ['login' => $user->login]) ?></p>

    <p><?= Yii::t('auth', 'Follow the link below to reset your password:') ?></p>

    <p><?= Html::a(Html::encode($emailLink), $emailLink) ?></p>
</div>
