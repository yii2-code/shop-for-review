<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \shop\entities\Auth\User */

$emailLink = Yii::$app->urlManager->createAbsoluteUrl(['/auth/user/active-email', 'token' => $user->email_active_token]);
?>
<div class="password-reset">
    <p><?= Yii::t('auth', 'Hello {login}', ['login' => Html::encode($user->login)]) ?></p>

    <p><?= Yii::t('auth', 'Thanks for singing up with Shop. You must follow this link to activate your email:') ?></p>

    <p><?= Html::a(Html::encode($emailLink), $emailLink) ?></p>

</div>
