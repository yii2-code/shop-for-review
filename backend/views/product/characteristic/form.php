<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 20:11
 */

use shop\helpers\CharacteristicHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $type \shop\types\Product\CharacteristicType */

$js = <<<JS
    $('#add-variant').on('click', function(event) {
        var prototype = $(this).data('prototype');
        event.preventDefault();
        $('#body-variants').append(prototype);
    });

    $('#body-variants').on('click', '.remove-variant', function() {
        $(this).closest('.form-group').detach();
    });
JS;


$this->registerJs($js);

?>

<?php $form = ActiveForm::begin(['enableClientScript' => false]) ?>

<?= $form->field($type, 'title')->textInput() ?>

<?= $form->field($type, 'type')->dropDownList(CharacteristicHelper::getTypeDropDown()) ?>

<?= $form->field($type, 'required')->dropDownList(CharacteristicHelper::getRequiredDropDown()) ?>

<?= $form->field($type, 'default')->textInput() ?>

<div class="form-group">
    <div class="form-group">
        <a id="add-variant" class="btn btn-info"
           data-prototype="<?= Html::encode($this->render('variants', ['type' => $type])) ?>">Add variant</a>
    </div>

    <div id="body-variants">
        <?= $form->field($type, 'variants')->hiddenInput(['value' => ''])->label(false); ?>
        <?php foreach ($type->variants as $variant): ?>
            <?= $this->render('variants', ['type' => $type, 'variant' => $variant]) ?>
        <?php endforeach; ?>
    </div>
</div>
<div class="form-group">
    <?= Html::submitButton($type->model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-success']) ?>
</div>
<?php $form::end(); ?>
