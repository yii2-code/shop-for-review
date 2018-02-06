<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 17:17
 */

namespace app\modules\image\services;


use RuntimeException;
use yii\helpers\FileHelper;

/**
 * Class Config
 * @package app\modules\image\services
 */
class Config
{
    /**
     * @var string
     */
    public $path;
    /**
     * @var string
     */
    public $thumbPath;
    /**
     * @var string
     */
    public $url;
    /**
     * @var string
     */
    public $thumbUrl;
    /**
     * @var array
     */
    public $thumbs = [];

    /**
     * Config constructor.
     * @param string $path
     * @param string $thumbPath
     * @param string $url
     * @param string $thumbUrl
     * @param array $thumbs
     * @throws \yii\base\Exception
     */
    public function __construct(
        string $path,
        string $thumbPath,
        string $url,
        string $thumbUrl,
        array $thumbs = []
    )
    {
        $this->path = rtrim($path, '/');
        $this->thumbPath = rtrim($thumbPath, '/');

        $this->url = rtrim($url, '/');
        $this->thumbUrl = rtrim($thumbUrl, '/');

        $this->thumbs = $thumbs;
        if (!FileHelper::createDirectory($this->path)) {
            throw new RuntimeException('Unable to create directory');
        }
        if (!FileHelper::createDirectory($this->thumbPath)) {
            throw new RuntimeException('Unable to create directory thumb');
        }
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function getSrcPath(string $fileName)
    {
        return sprintf('%s/%s', $this->getPath(), $fileName);
    }

    /**
     * @return string
     */
    public function getThumbPath(): string
    {
        return $this->thumbPath;
    }

    /**
     * @param string $fileName
     * @return string
     */
    public function getSrcThumbPath(string $fileName): string
    {
        return $this->getThumbPath() . '/' . $fileName;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getThumbUrl(): string
    {
        return $this->thumbUrl;
    }

    /**
     * @return array
     */
    public function getThumbs(): array
    {
        return $this->thumbs;
    }
}