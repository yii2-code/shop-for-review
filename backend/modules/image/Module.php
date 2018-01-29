<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 17:10
 */

namespace backend\modules\image;


use backend\modules\image\models\ImageRepository;
use backend\modules\image\services\ImageManager;
use Yii;
use yii\base\BootstrapInterface;

class Module extends \yii\base\Module implements BootstrapInterface
{
    public $path;

    public $url;

    public $thumbPath;
    public $thumbUrl;
    public $thumbs = [];

    /**
     * @var int
     */
    public $maxFiles = 20;

    /**
     * @var string
     */
    private $identitySession = '_image_token';

    const IMAGE = 'image';

    public function bootstrap($app)
    {
        $container = Yii::$container;

        $container->setSingleton(static::IMAGE, function () use ($container) {
            return new ImageManager(
                new ImageRepository(),
                $this->path,
                $this->url,
                $this->thumbPath,
                $this->thumbUrl,
                $this->identitySession,
                $this->maxFiles,
                $this->thumbs
            );
        });
    }
}