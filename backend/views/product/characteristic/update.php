<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 17:30
 */

/** @var $this \yii\web\View */
/** @var $type \shop\types\Product\CharacteristicType */

$this->title = $type->model->title;

$this->params['breadcrumbs'][] = ['label' => 'Characteristic', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>

    <?= $this->render('form', ['type' => $type]) ?>
</div>