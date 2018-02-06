<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 18:51
 */

declare(strict_types=1);

namespace app\modules\image\TDO;


use app\modules\image\helper\ImageHelper;
use app\modules\image\models\Image;
use app\modules\image\services\Config;
use app\modules\image\services\ImageManager;
use app\modules\image\services\ImageManagerInterface;
use app\modules\image\services\Upload;
use app\modules\image\services\View;
use app\modules\image\types\UpdateType;
use yii\helpers\Url;

/**
 * Class Image
 * @package app\modules\image\TDO
 */
class ImageTdo
{
    /**
     * @var Image
     */
    private $image;

    /**
     * @var ImageManager
     */
    private $imageManager;
    /**
     * @var Config
     */
    private $config;

    /** @var View */
    private $view;

    /**
     * Image constructor.
     * @param Image $image
     * @param ImageManagerInterface $imageManager
     * @param Config $config
     */
    public function __construct(Image $image, ImageManagerInterface $imageManager, Config $config)
    {
        $this->image = $image;
        $this->imageManager = $imageManager;
        $this->config = $config;
        $this->view = new View($this->config, new Upload($this->config));
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->image->id;
    }

    /**
     * @return string
     */
    public function getUrlSrc(): ?string
    {
        if ($this->view->isFile($this->image->src)) {
            return $this->config->getUrl() . $this->image->src;
        }

        return $this->view->getPlaceholder();
    }

    /**
     * @param $thumb
     * @return string
     */
    public function getUrlThumb(string $thumb): ?string
    {
        if ($this->view->isThumbFile($thumb, $this->image->src)) {
            return $this->config->getThumbUrl() . ImageHelper::constructThumbName($thumb, $this->image->src);
        }
        return $this->view->getThumbPlaceholder($thumb);
    }

    /**
     * @return UpdateType
     */
    public function createUpdateType(): UpdateType
    {
        return $this->imageManager->createService()->createUpdateType($this->image);
    }

    /**
     * @return array
     */
    public function getActionForImage(): array
    {
        return ['/image/image/update', 'id' => $this->getId()];
    }

    /**
     * @param $attribute
     * @return string
     */
    public function getAttributeLabel($attribute): string
    {
        return $this->image->getAttributeLabel($attribute);
    }

    /**
     * @return string
     */
    public function getUrlDelete(): string
    {
        return Url::to(['/image/image/delete', 'id' => $this->getId()]);
    }

    /**
     * @return string
     */
    public function getUrlMoveUp(): string
    {
        return Url::to(['/image/image/move-up', 'id' => $this->getId()]);
    }

    /**
     * @return string
     */
    public function getUrlMoveDown(): string
    {
        return Url::to(['/image/image/move-down', 'id' => $this->getId()]);
    }

    /**
     * @return string
     */
    public function getUrlActiveMain(): string
    {
        return Url::to(['/image/image/active-main', 'id' => $this->getId()]);
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->image->created_at;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->image->updated_at;
    }

    /**
     * @return bool
     */
    public function isMain(): bool
    {
        return $this->image->isMain();
    }
}