<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 11.02.18
 * Time: 23:43
 */

use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var $this \yii\web\View */
/** @var $model \shop\entities\Auth\User */

$this->title = $model->login;

$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title];

?>

<div>
    <h1><?= $this->title ?></h1>

    <p><a href="<?= Url::to(['update', 'id' => $model->id]) ?>"
          class="btn btn-primary"><?= Yii::t('yii', 'Update') ?></a></p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'login',
            'email',
            [
                'attribute' => 'status',
                'value' => $model->getStatus(),
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ]
    ]) ?>
</div>
