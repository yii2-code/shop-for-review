<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 30.01.18
 * Time: 13:06
 */

namespace app\modules\tag\assets;


use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class TagsInputAsset
 * @package app\modules\tag\assets
 */
class TagsInputAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/bootstrap-tagsinput/bootstrap-tagsinput/dist';

    /**
     * @var array
     */
    public $css = [
        'bootstrap-tagsinput.css',
    ];

    /**
     * @var array
     */
    public $js = [
        'bootstrap-tagsinput.min.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
        BootstrapAsset::class,
    ];
}