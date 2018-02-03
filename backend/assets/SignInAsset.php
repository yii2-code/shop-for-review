<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 23:21
 */

namespace backend\assets;

use yii\bootstrap\BootstrapAsset;
use yii\web\AssetBundle;

class SignInAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/signin.css'
    ];

    public $depends = [
        BootstrapAsset::class,
    ];
}