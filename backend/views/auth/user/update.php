<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 11.02.18
 * Time: 23:53
 */

/** @var $this \yii\web\View */
/** @var $type \shop\types\Auth\UserType */

$this->title = $type->login;

$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title, 'url' => ['view', 'id' => $type->model->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yii', 'Update')];

?>

<div>

    <h1><?= $this->title ?></h1>

    <?= $this->render('form', ['type' => $type]) ?>
</div>
