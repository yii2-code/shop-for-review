<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 18:34
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $this \yii\web\View */
/** @var $images array */
/** @var $imageWarning string */

?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php if (isset($warning)) : ?>
            <div class="alert alert-warning"><?= $warning ?></div>
        <?php endif; ?>
        <?php foreach ($images as $row) : ?>
            <div class="row">
                <?php foreach ($row as $image): ?>
                    <?php /**@var $image \backend\modules\image\TDO\ImageTdo */ ?>
                    <?php if (isset($id) && $image->getId() == $id && isset($imageWarning)): ?>
                        <div class="alert alert-warning"><?= $imageWarning ?></div>
                    <?php endif; ?>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <img src="<?= $image->getUrlSrc() ?>" alt="">

                            <div class="caption">
                                <?php $form = ActiveForm::begin(['action' => $image->getActionForImage(), 'enableClientScript' => false, 'options' => ['class' => 'uploaded-image']]) ?>
                                <?= $form->field($image->createUpdateType(), 'name')->textInput() ?>
                                <div class="form-group">
                                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
                                </div>
                                <?php $form::end() ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>