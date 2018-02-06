<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 04.02.18
 * Time: 17:37
 */

namespace app\modules\image\services;

use app\modules\image\helper\ImageHelper;
use RuntimeException;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * Class ImageCreateService
 * @package app\modules\image\services
 */
class Upload
{
    /**
     * @var Config
     */
    private $config;

    /**
     * ImageCreateService constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {

        $this->config = $config;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function upload(UploadedFile $file): string
    {
        $tmpName = $this->generateName($file);
        $path = $this->config->getPath() . $tmpName;
        if (!$file->saveAs($path)) {
            throw new RuntimeException('Unable to save image');
        }
        return $tmpName;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    protected function generateName(UploadedFile $file): string
    {
        return md5(uniqid($file->baseName)) . '.' . $file->getExtension();
    }

    /**
     * @param string $src
     */
    public function createThumbs(string $src): void
    {
        foreach ($this->config->getThumbs() as $name => $config) {
            $this->createThumb(ImageHelper::constructThumbName($name, $src), $config, $this->config->getPath() . $src);
        }
    }

    /**
     * @param string $name
     * @param array $config
     * @param string $fullPath
     */
    public function createThumb(string $name, array $config, string $fullPath): void
    {
        $width = ArrayHelper::getValue($config, 'width');
        $height = ArrayHelper::getValue($config, 'height');
        $quality = ArrayHelper::getValue($config, 'quality', 100);
        $path = $this->config->getThumbPath() . $name;
        \yii\imagine\Image::thumbnail($fullPath, $width, $height)->save($path, ['quality' => $quality]);
    }

    /**
     * @param string $src
     */
    public function unlink(string $src): void
    {
        $this->unlinkSrc($src);
        $this->unlinkThumbs($src);
    }

    /**
     * @param string $src
     */
    protected function unlinkSrc(string $src): void
    {
        $file = $this->config->getPath() . $src;
        if (file_exists($file) && !unlink($file)) {
            throw new RuntimeException('Unable to unlink file');
        };
    }

    /**
     * @param string $src
     */
    protected function unlinkThumbs(string $src): void
    {
        foreach ($this->config->getThumbs() as $name => $config) {
            $this->unlinkThumb(ImageHelper::constructThumbName($name, $src));
        }
    }

    /**
     * @param string $name
     */
    protected function unlinkThumb(string $name): void
    {
        $file = $this->config->getThumbPath() . $name;
        if (file_exists($file) && !unlink($file)) {
            throw new RuntimeException('Unable to unlink file');
        };
    }
}