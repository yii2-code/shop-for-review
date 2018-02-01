<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 20:11
 */

use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Product\CharacteristicType */
/** @var $variant string */

?>
<div class="form-group">
    <div class="input-group">
        <?= Html::activeTextInput($type, 'variants[]', ['value' => $variant ?? null, 'class' => 'form-control']) ?>
        <span class="input-group-btn"><button class="btn btn-default remove-variant" type="button"><span>&times;</span></button></span>
    </div>

</div>

