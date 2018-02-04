<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 04.02.18
 * Time: 17:37
 */

namespace app\modules\image\services;

use RuntimeException;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class ImageCreateService
 * @package app\modules\image\services
 */
class Image
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var array
     */
    private $thumbs;

    /**
     * @var string
     */
    private $thumbPath;

    /**
     * ImageCreateService constructor.
     * @param string $path
     * @param string $thumbPath
     * @param array $thumbs
     * @throws \yii\base\Exception
     */
    public function __construct(
        string $path,
        string $thumbPath,
        array $thumbs
    )
    {
        $this->path = rtrim($path, '/');
        $this->thumbPath = rtrim($thumbPath, '/');
        $this->thumbs = $thumbs;
        if (!FileHelper::createDirectory($this->path)) {
            throw new RuntimeException('Unable to create directory');
        }
        if (!FileHelper::createDirectory($this->thumbPath)) {
            throw new RuntimeException('Unable to create directory thumb');
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function create(UploadedFile $file): string
    {
        $tmpName = $this->generateName($file);
        $path = $this->getSrcPath($tmpName);
        if (!$file->saveAs($path)) {
            throw new RuntimeException('Unable to save image');
        }
        return $tmpName;
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    public function generateName(UploadedFile $file): string
    {
        return md5(uniqid($file->baseName)) . '.' . $file->getExtension();
    }

    /**
     * @param string $name
     * @return string
     */
    public function getSrcPath(string $name)
    {
        return sprintf('%s/%s', $this->getPath(), $name);
    }

    /**
     * @param string $src
     * @param string $path
     */
    public function createThumbs(string $src, string $path): void
    {
        foreach ($this->getThumbs() as $name => $config) {
            $this->createThumb($this->getThumbName($name, $src), $config, $path);
        }
    }

    /**
     * @param string $name
     * @param string $src
     * @return string
     */
    public function getThumbName(string $name, string $src): string
    {
        return "$name-$src";
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
        $path = $this->getSrcThumbPath($name);
        \yii\imagine\Image::thumbnail($fullPath, $width, $height)->save($path, ['quality' => $quality]);
    }


    /**
     * @param string $src
     */
    public function unlink(string $src): void
    {
        $file = $this->getSrcPath($src);
        if (file_exists($file) && !unlink($file)) {
            throw new RuntimeException('Unable to unlink file');
        };
    }

    /**
     * @param string $src
     */
    public function unlinkThumbs(string $src): void
    {
        foreach ($this->getThumbs() as $name => $config) {
            $this->unlinkThumb($this->getThumbName($name, $src));
        }
    }

    /**
     * @param string $name
     */
    public function unlinkThumb(string $name): void
    {
        $file = $this->getSrcThumbPath($name);
        if (file_exists($file) && !unlink($file)) {
            throw new RuntimeException('Unable to unlink file');
        };
    }


    /**
     * @param string $src
     * @return string
     */
    public function getSrcThumbPath(string $src): string
    {
        return $this->getThumbPath() . '/' . $src;
    }

    /**
     * @return array
     */
    public function getThumbs(): array
    {
        return $this->thumbs;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getThumbPath(): string
    {
        return $this->thumbPath;
    }
}