<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 17:02
 */

use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;
use yii\widgets\Pjax;

/** @var $this \yii\web\View */
/** @var $type \app\modules\image\types\ImageType */
/** @var $action array */
/** @var $images array */

?>

<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(
            [
                'action' => $action,
                'enableClientScript' => false,
                'options' => [
                    'enctype' => 'multipart/form-data',
                    'class' => 'uploaded-image',
                ],
            ]
        ); ?>
        <?= $form->field($type, 'image[]')->fileInput(['multiple' => true]); ?>
        <?= Html::submitButton('Upload', ['class' => 'btn btn-success']); ?>
        <?php $form::end(); ?>
    </div>
</div>

<?php Pjax::begin([
    'enablePushState' => false,
    'formSelector' => '.uploaded-image'
]) ?>
<?= $this->render('@app/modules/image/views/image/gallery.php', ['images' => $images]) ?>
<?php Pjax::end() ?>
