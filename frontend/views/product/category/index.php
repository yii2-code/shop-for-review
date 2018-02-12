<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.02.18
 * Time: 17:49
 */

use yii\helpers\Url;
use yii\widgets\LinkPager;

/** @var $this \yii\web\View */
/** @var $dataProvider \yii\data\ActiveDataProvider */
/** @var $parents \shop\entities\Product\Category[] */
/** @var $category \shop\entities\Product\Category */

$this->title = $category->title;

foreach ($parents as $parent) {
    $this->params['breadcrumbs'][] = ['label' => $parent->title, 'url' => ['/product/category/index', 'id' => $parent->id]];
}

$this->params['breadcrumbs'][] = ['label' => $category->title]

?>
    <div class="row">
        <div class="col-md-2  col-md-offset-8">
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">Sort By:</span>
                    <?php
                    $sort = [
                        '' => 'Default',
                        'title' => 'Name (A - Z)',
                        '-title' => 'Name (Z - A)',
                        'price' => 'Price (Low &gt; High)',
                        '-price' => 'Price (High &gt; Low)',
                    ];
                    $current = Yii::$app->request->get($dataProvider->getSort()->sortParam, '');
                    ?>
                    <select class="form-control" onchange=" location = this.value">
                        <?php foreach ($sort as $param => $name): ?>
                            <option value="<?= Url::current([$dataProvider->getSort()->sortParam => $param]) ?>" <?= $current == $param ? 'selected' : null ?>>
                                <?= $name ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <div class="input-group">
                    <?php
                    $show = [16, 32, 48, 64, 80];
                    $count = Yii::$app->request->get($dataProvider->getPagination()->pageSizeParam, 16);
                    ?>

                    <span class="input-group-addon">Show:</span>
                    <select class="form-control" onchange="location = this.value">
                        <?php foreach ($show as $value): ?>
                            <option value="<?= Url::current([$dataProvider->getPagination()->pageSizeParam => $value]) ?>" <?= $value == $count ? 'selected' : null ?>>
                                <?= $value ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

<?php foreach (array_chunk($dataProvider->getModels(), 4) as $models): ?>
    <div class="row">
        <?php foreach ($models as $model): ?>
            <?= $this->render('@frontend/views/parts/product', ['model' => $model]) ?>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

<?= LinkPager::widget(['pagination' => $dataProvider->getPagination()]); ?>