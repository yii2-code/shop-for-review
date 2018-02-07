<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 07.02.18
 * Time: 14:48
 */

namespace backend\assets;


use yii\web\AssetBundle;

/**
 * Class Wysihtml5Asset
 * @package backend\assets
 */
class Wysihtml5Asset extends AssetBundle
{

    /**
     * @var string
     */
    public $sourcePath = '@vendor/almasaeed2010/adminlte/plugins/bootstrap-wysihtml5';

    /**
     * @var array
     */
    public $js = [
        'bootstrap3-wysihtml5.all.js',
    ];

    /**
     * @var array
     */
    public $css = [
        'bootstrap3-wysihtml5.css',
    ];

    /**
     * @param \yii\web\View $view
     */
    public function registerAssetFiles($view)
    {
        $view->registerJs('$(".wysihtml5").wysihtml5()');
        parent::registerAssetFiles($view);
    }


    /**
     * @var array
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}