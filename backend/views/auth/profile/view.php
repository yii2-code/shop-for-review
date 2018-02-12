<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 12.02.18
 * Time: 23:38
 */

use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var $this \yii\web\View */
/** @var $model \shop\entities\Auth\Profile */

$this->title = $model->user->login;

$this->params['breadcrumbs'][] = ['label' => 'Profile', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

    <div>

        <h1><?= $this->title ?></h1>

        <p><a href="<?= Url::to(['update', 'id' => $model->id]) ?>"
              class="btn btn-success"><?= Yii::t('yii', 'Update') ?></a></p>
    </div>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        'first_name',
        'middle_name',
        'last_name',
        'about:html',
        'created_at:datetime',
        'updated_at:datetime',
    ]
]) ?>