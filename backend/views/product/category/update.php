<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 17:30
 */

use yii\helpers\Url;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Product\CategoryType */

$this->title = $type->model->title;

$this->params['breadcrumbs'][] = ['label' => 'Category', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>

    <p>
        <a href="<?= Url::to(['view', 'id' => $type->model->id]) ?>"></a>
    </p>

    <?= $this->render('form', ['type' => $type]) ?>
</div>

