<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 17:10
 */

namespace app\modules\image;


use app\modules\image\models\ImageRepository;
use app\modules\image\services\ImageManager;
use app\modules\image\services\ImageManagerInterface;
use Yii;
use yii\base\BootstrapInterface;

/**
 * Class Module
 * @package app\modules\image
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /**
     * @var
     */
    public $path;

    /**
     * @var
     */
    public $url;

    /**
     * @var
     */
    public $thumbPath;
    /**
     * @var
     */
    public $thumbUrl;
    /**
     * @var array
     */
    public $thumbs = [];

    /**
     * @var int
     */
    public $maxFiles = 20;


    /**
     * @var
     */
    public $placeholderPath;

    /**
     * @var string
     */
    private $identitySession = '_image_token';

    /**
     * @param \yii\base\Application $app
     */
    public function bootstrap($app)
    {
        $container = Yii::$container;

        $container->setSingleton(ImageManagerInterface::class, function () use ($container) {
            return new ImageManager(
                new ImageRepository(),
                $this->path,
                $this->url,
                $this->thumbPath,
                $this->thumbUrl,
                $this->identitySession,
                $this->maxFiles,
                $this->thumbs,
                $this->placeholderPath
            );
        });
    }
}