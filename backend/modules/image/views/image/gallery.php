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
/** @var $message string */

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
                    <?php if (isset($id) && $image->getId() == $id && isset($message)): ?>
                        <div class="col-md-12">
                            <div class="alert alert-info"><?= $message ?></div>
                        </div>
                    <?php endif; ?>
                    <div class="col-md-4">
                        <div class="thumbnail">
                            <img src="<?= $image->getUrlSrc() ?>" alt="">

                            <div class="caption">
                                <?php $form = ActiveForm::begin(['action' => $image->getActionForImage(), 'enableClientScript' => false, 'options' => ['class' => 'uploaded-image']]) ?>
                                <?= $form->field(
                                    $image->createUpdateType(),
                                    'name',
                                    [
                                        'template' => sprintf("{label}\n<div class=\"input-group\"><div class=\"input-group-addon\">%s</div>{input}</div>\n{hint}\n{error}", $image->getAttributeLabel('name'))
                                    ]
                                )->textInput(['class' => 'form-control input-sm'])->label(false); ?>
                                <div class="form-group btn-group">
                                    <?= Html::submitButton('Update', ['class' => 'btn btn-primary btn-xs']) ?>
                                    <?= Html::a('Delete', $image->getUrlDelete(), ['class' => 'btn btn-danger btn-xs']) ?>
                                </div>
                                <?php $form::end() ?>
                                <p>
                                    <span class="label label-info">Created At: <?= Yii::$app->formatter->asDatetime($image->getCreatedAt()); ?></span>
                                </p>
                                <p>
                                    <span class="label label-info">Updated At: <?= Yii::$app->formatter->asDatetime($image->getUpdatedAt()); ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>