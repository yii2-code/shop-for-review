<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 18:40
 */

declare(strict_types=1);

namespace app\modules\image\services;


use app\modules\image\helper\ImageHelper;

/**
 * Class View
 * @package app\modules\image\services
 */
class View
{
    /**
     * @var Config
     */
    private $config;
    /**
     * @var Upload
     */
    private $upload;

    /**
     * View constructor.
     * @param Config $config
     * @param Upload $upload
     */
    public function __construct(Config $config, Upload $upload)
    {

        $this->config = $config;
        $this->upload = $upload;
    }

    /**
     * @param string $fileName
     * @return bool
     */
    public function isFile(string $fileName): bool
    {
        return is_file($this->config->getPath() . $fileName);
    }


    /**
     * @param string $thumb
     * @param string $fileName
     * @return bool
     */
    public function isThumbFile(string $thumb, string $fileName): bool
    {
        return is_file($this->config->getThumbPath() . ImageHelper::constructThumbName($thumb, $fileName));
    }

    /**
     * @return null|string
     */
    public function getPlaceholder(): ?string
    {
        if ($this->config->isPlaceholder()) {
            if (!is_file($this->config->getPath() . $this->config->getFileNamePlaceholder())) {
                $this->copyPlaceholder();
            }
            return $this->config->getUrl() . $this->config->getFileNamePlaceholder();
        }

        return null;
    }

    /**
     * @param string $thumb
     * @return null|string
     */
    public function getThumbPlaceholder(string $thumb): ?string
    {
        if ($this->config->isPlaceholder()) {
            if (!isset($this->config->getThumbs()[$thumb])) {
                return $this->getPlaceholder();
            }
            if (!is_file($this->config->getThumbUrl() . ImageHelper::constructThumbName($thumb, $this->config->getFileNamePlaceholder()))) {
                $this->createThumbPlaceholder($thumb);
            }
            return $this->config->getThumbUrl() . ImageHelper::constructThumbName($thumb, $this->config->getFileNamePlaceholder());
        }
    }

    /**
     * @param string $thumb
     */
    public function createThumbPlaceholder(string $thumb): void
    {
        $this->upload->createThumb(ImageHelper::constructThumbName($thumb, 'placeholder.png'), $this->config->getThumbs()[$thumb], $this->config->getPlaceholderPath());
    }

    /**
     * @return bool
     */
    public function copyPlaceholder(): bool
    {
        return copy($this->config->getPlaceholderPath(), $this->config->getPath() . $this->config->getFileNamePlaceholder());
    }


}