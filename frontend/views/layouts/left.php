<?php

use \shop\widgets\category\MenuWidget;

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
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
                <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <?= MenuWidget::widget(); ?>
    </section>

</aside>
