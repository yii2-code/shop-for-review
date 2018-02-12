<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 12.02.18
 * Time: 23:27
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Auth\ProfileType */

$this->title = Yii::t('yii', 'Update');

$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $type->model->user->login, 'url' => ['view']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

    <?= $form->field($type, 'firstName') ?>

    <?= $form->field($type, 'middleName') ?>

    <?= $form->field($type, 'lastName') ?>

    <?= $form->field($type, 'about')->textarea() ?>

    <?= $form->field($type, 'src')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('yii', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>
    <?php $form::end() ?>
</div>

