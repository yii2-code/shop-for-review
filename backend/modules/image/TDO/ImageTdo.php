<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 18:51
 */

declare(strict_types=1);

namespace backend\modules\image\TDO;


use backend\modules\image\models\Image;
use backend\modules\image\services\ImageManager;
use backend\modules\image\types\UpdateType;
use yii\helpers\Url;

/**
 * Class Image
 * @package backend\modules\image\TDO
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
     * Image constructor.
     * @param Image $image
     * @param ImageManager $imageManager
     */
    public function __construct(Image $image, ImageManager $imageManager)
    {
        $this->image = $image;
        $this->imageManager = $imageManager;
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
    public function getUrlSrc(): string
    {
        return $this->imageManager->getUrl() . '/' . $this->image->src;
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