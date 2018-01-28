<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 23:08
 */

declare(strict_types=1);

namespace backend\modules\image\services;

use backend\modules\image\models\Image;
use backend\modules\image\types\ImageType;
use backend\modules\image\types\UpdateType;
use RuntimeException;
use Yii;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * Class ImageService
 * @package backend\modules\image\services
 */
class ImageService
{
    /**
     * @var ImageManager
     */
    private $imageManager;

    /**
     * ImageService constructor.
     * @param ImageManager $imageManager
     * @throws \yii\base\Exception
     */
    public function __construct(
        ImageManager $imageManager
    )
    {
        $this->imageManager = $imageManager;
        if (!FileHelper::createDirectory($this->imageManager->getPath())) {
            throw new RuntimeException('Unable to create directory');
        }
    }

    /**
     * @return ImageType
     */
    public function createType(): ImageType
    {
        return new ImageType($this->imageManager->maxFiles);
    }


    /**
     * @param Image|null $model
     * @return UpdateType
     */
    public function createUpdateType(Image $model = null): UpdateType
    {
        return new UpdateType($model);
    }

    /**
     * @param ImageType $type
     * @return bool
     */
    public function validate(ImageType $type): bool
    {
        if ($type->maxFiles == 1) {
            $type->image = UploadedFile::getInstance($type, 'image');
        } else {
            $type->image = UploadedFile::getInstances($type, 'image');
        }
        return $type->validate();
    }

    /**
     * @param UploadedFile $file
     * @param string $class
     * @param int|null $recordId
     * @return Image
     */
    public function create(UploadedFile $file, string $class, int $recordId = null): Image
    {
        $tmpName = md5(uniqid($file->baseName)) . '.' . $file->getExtension();
        $path = sprintf('%s/%s', $this->imageManager->getPath(), $tmpName);
        if (!$file->saveAs($path)) {
            throw new RuntimeException('Unable to save image');
        }
        $image = Image::create($file->name, $tmpName, $class);
        if (!is_null($recordId)) {
            $image->setRecordId($recordId);
        } else {
            $token = $this->imageManager->getToken();
            $image->setToken($token);
        }
        $this->save($image);
        return $image;
    }

    /**
     * @param array $files
     * @param string $class
     * @param int|null $recordId
     * @return array
     */
    public function creates(array $files, string $class, int $recordId = null): array
    {
        $images = [];
        foreach ($files as $file) {
            $images[] = $this->create($file, $class, $recordId);
        }
        return $images;
    }

    /**
     * @param int $recordId
     * @param string $class
     * @return array|Image[]
     */
    public function editAfterCreatedRecord(int $recordId, string $class)
    {
        $images = $this->imageManager->getImagesByToken($class);
        foreach ($images as $image) {
            $image->record_id = $recordId;
            $image->removeToken();
            $this->save($image);
        }
        return $images;
    }

    /**
     * @param int $id
     * @param UpdateType $type
     * @return Image
     * @throws NotFoundHttpException
     */
    public function edit(int $id, UpdateType $type): Image
    {
        $image = $this->imageManager->getRepository()->findOne($id);
        $this->notFoundHttpException($image);
        $image->edit($type->name);
        $this->save($image);
        return $image;
    }

    /**
     * @param Image $model
     */
    public function save(Image $model)
    {
        if (!$model->save()) {
            throw new RuntimeException('Saving error');
        }
    }

    /**
     * @param Image|null $image
     * @throws NotFoundHttpException
     */
    public function notFoundHttpException(Image $image = null)
    {
        if (is_null($image)) {
            throw new NotFoundHttpException(Yii::t('yii', 'The page not found.'));
        }
    }
}