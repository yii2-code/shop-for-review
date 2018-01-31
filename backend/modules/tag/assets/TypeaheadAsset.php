<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 30.01.18
 * Time: 14:34
 */

namespace backend\modules\tag\assets;


use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Class TypeaheadAsset
 * @package backend\modules\tag\assets
 */
class TypeaheadAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@bower/typeahead.js/dist';

    /**
     * @var array
     */
    public $js = [
        'typeahead.bundle.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        JqueryAsset::class,
    ];
}