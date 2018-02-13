<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 13.02.18
 * Time: 18:40
 */

use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\search\product\SearchType */

?>

<!-- search form -->
<?= Html::beginForm(['/product/search/index'], 'get', ['class' => 'sidebar-form']) ?>

<div class="input-group">
    <?= Html::activeTextInput($type, 'keywords', ['class' => 'form-control', 'placeholder' => 'Search...']) ?>
    <span class="input-group-btn">
            <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
         </span>
</div>
<?= Html::endForm() ?>
