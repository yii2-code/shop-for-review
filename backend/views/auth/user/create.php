<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 11.02.18
 * Time: 23:20
 */

/** @var $this \yii\web\View */
/** @var $type \shop\types\Auth\UserType */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>

    <?= $this->render('form', ['type' => $type]) ?>
</div>
