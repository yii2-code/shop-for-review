<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 16:46
 */

/** @var $this \yii\web\View */
/** @var $type \shop\types\Product\BrandType */

$this->title = 'Create';

$this->params['breadcrumbs'][] = ['label' => 'Brand', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>
    <?= $this->render('form', ['type' => $type]) ?>
</div>
