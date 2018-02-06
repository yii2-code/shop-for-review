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
    protected $path;
    /**
     * @var string
     */
    protected $thumbPath;
    /**
     * @var string
     */
    protected $url;
    /**
     * @var string
     */
    protected $thumbUrl;
    /**
     * @var array
     */
    protected $thumbs = [];

    /**
     * @var null|string
     */
    protected $placeholderPath;

    /**
     * @var string
     */
    protected $fileNamePlaceholder = 'placeholder.png';

    /**
     * Config constructor.
     * @param string $path
     * @param string $thumbPath
     * @param string $url
     * @param string $thumbUrl
     * @param array $thumbs
     * @param string|null $placeholder
     * @throws \yii\base\Exception
     */
    public function __construct(
        string $path,
        string $thumbPath,
        string $url,
        string $thumbUrl,
        array $thumbs = [],
        string $placeholder = null
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
        if (!is_null($this->placeholderPath) && !is_file($this->placeholderPath)) {
            throw new RuntimeException('Placeholder not found');
        }
        $this->placeholderPath = $placeholder;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path . '/';
    }

    /**
     * @return string
     */
    public function getThumbPath(): string
    {
        return $this->thumbPath . '/';
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url . '/';
    }

    /**
     * @return string
     */
    public function getThumbUrl(): string
    {
        return $this->thumbUrl . '/';
    }

    /**
     * @return array
     */
    public function getThumbs(): array
    {
        return $this->thumbs;
    }


    /**
     * @return bool
     */
    public function isPlaceholder(): bool
    {
        return !is_null($this->placeholderPath);
    }

    /**
     * @return string
     */
    public function getPlaceholderPath(): string
    {
        return $this->placeholderPath;
    }

    /**
     * @return string
     */
    public function getFileNamePlaceholder(): string
    {
        return $this->fileNamePlaceholder;
    }
}