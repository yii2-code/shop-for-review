<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 04.02.18
 * Time: 16:37
 */

/** @var $this \yii\web\View */
/** @var $menu array */

array_unshift($menu, ['label' => 'Menu Yii2', 'options' => ['class' => 'header']])

?>

<?= dmstr\widgets\Menu::widget(
    [
        'options' => ['class' => 'sidebar-menu tree', 'data-widget' => 'tree'],
        'items' => $menu,
    ]
) ?>
