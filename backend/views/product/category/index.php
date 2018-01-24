<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 17:20
 */

use yii\grid\ActionColumn;
use yii\helpers\Url;

/** @var $dataProvider \yii\data\ActiveDataProvider */

?>

<p>
    <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">Create</a>
</p>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        'title',
        ['class' => ActionColumn::class],
    ]
]) ?>
