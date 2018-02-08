<?php

/* @var $this yii\web\View */

use shop\widgets\product\CarouselWidget;
use shop\widgets\product\ListOnMainWidget;

$this->title = 'Shop';

?>

<?= CarouselWidget::widget(); ?>

<?= ListOnMainWidget::widget() ?>