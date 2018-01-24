<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 16:35
 */

use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/** @var $type \shop\types\Auth\SignInType */
/* @var $this yii\web\View */

?>

<?php $form = ActiveForm::begin(['options' => ['class' => 'form-signin'],]); ?>
<h2 class="form-signin-heading">Please sign in</h2>
<?= $form->field($type, 'login')
    ->textInput(['placeholder' => "Login", 'required' => true, 'autofocus' > true])
    ->label(false)
?>
<?= $form->field($type, 'password')
    ->passwordInput(['placeholder' => "Password", 'required' => true])
    ->label(false)
?>

<div class="form-group checkbox">
    <label>
        <input type="checkbox" value="remember-me"> Remember me
    </label>
</div>

<div class="form-group" style="color:#999;margin:1em 0">
    If you forgot your password you can <?= Html::a('reset it', ['/request']) ?>.
</div>

<div class="form-group">
        <?= AuthChoice::widget([
            'baseAuthUrl' => ['/oauth'],
            'popupMode' => false,
        ]) ?>
    </div>

<?= Html::submitButton('Sign in', ['class' => 'btn btn-lg btn-primary btn-block']) ?>
<?php ActiveForm::end(); ?>
