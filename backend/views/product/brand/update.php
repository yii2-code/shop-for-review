<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 17:34
 */

/** @var $this \yii\web\View */
/** @var $type \shop\types\Product\BrandType */

/** @var $this \yii\web\View */

$this->title = $type->model->title;

$this->params['breadcrumbs'][] = ['label' => 'Brand', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];


?>

<div>
    <h1><?= $this->title ?></h1>
    <?= $this->render('form', ['type' => $type]) ?>
</div>
