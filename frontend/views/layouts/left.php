<?php

use \shop\widgets\category\MenuWidget;
use shop\widgets\SearchWidget;

?>

<aside class="main-sidebar">

    <section class="sidebar">
        <?php if (!Yii::$app->user->isGuest): ?>
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= Yii::$app->user->identity->getAvatar('160x160', 160) ?>" class="img-circle"
                         alt="User Image"/>
                </div>
                <div class="pull-left info">
                    <p><?= Yii::$app->user->identity->login ?></p>
                </div>
            </div>
        <?php endif; ?>
        <?= SearchWidget::widget(); ?>
        <!-- /.search form -->
        <?= MenuWidget::widget(); ?>
    </section>

</aside>
