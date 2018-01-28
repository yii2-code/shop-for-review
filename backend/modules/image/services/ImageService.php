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
use DomainException;
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
     * @param int $position
     * @param int|null $main
     * @return Image
     */
    public function create(UploadedFile $file, string $class, int $position, int $recordId = null, int $main = null): Image
    {
        $tmpName = md5(uniqid($file->baseName)) . '.' . $file->getExtension();
        $path = sprintf('%s/%s', $this->imageManager->getPath(), $tmpName);
        if (!$file->saveAs($path)) {
            throw new RuntimeException('Unable to save image');
        }
        $image = Image::create($file->name, $tmpName, $class, $position, $main);
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
        $max = $this->maxPosition($class, $recordId);

        $images = [];
        foreach ($files as $file) {
            $max++;
            $images[] = $this->create($file, $class, $max, $recordId, $max == 1 ? Image::MAIN : null);
        }
        return $images;
    }

    /**
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function moveUp(int $id): array
    {
        return $this->move($id, function ($index) {
            return $index + 1;
        });
    }

    /**
     * @param int $id
     * @return array|Image[]
     * @throws NotFoundHttpException
     */
    public function moveDown(int $id): array
    {
        return $this->move($id, function ($index) {
            return $index - 1;
        });
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
     * @param int $id
     * @return array
     * @throws NotFoundHttpException
     */
    public function updateMain(int $id): array
    {
        $image = $this->imageManager->getRepository()->findOne($id);
        $this->notFoundHttpException($image);
        $images = $this->imageManager->getImages($image->class, $image->record_id);
        foreach ($images as $photo) {
            if ($photo->id == $id) {
                $photo->activeMain();
            } else {
                $photo->removeMain();
            }
        }
        foreach ($images as $index => $photo) {
            $this->save($photo);
        }
        return $images;
    }

    /**
     * @param int $id
     * @param callable $callable
     * @return array
     * @throws NotFoundHttpException
     */
    public function move(int $id, callable $callable): array
    {
        $image = $this->imageManager->getRepository()->findOne($id);
        $this->notFoundHttpException($image);
        $images = $this->imageManager->getImages($image->class, $image->record_id, SORT_ASC);
        $sort = false;
        foreach ($images as $index => $photo) {
            if ($photo->id == $id && isset($images[$callable($index)]) && $near = $images[$callable($index)]) {
                $images[$callable($index)] = $photo;
                $images[$index] = $near;
                $sort = true;
            }
        }
        if ($sort) {
            foreach ($images as $index => $photo) {
                $photo->setPosition($index + 1);
                $this->save($photo);
            }
        }
        return $images;
    }

    /**
     * @param string $class
     * @param int|null $recordId
     * @return int
     */
    public function maxPosition(string $class, int $recordId = null): int
    {
        if ($recordId) {
            $max = $this->imageManager->getRepository()->maxPositionByRecordIdClass($recordId, $class);
        } else {
            $token = $this->imageManager->getToken();
            $max = $this->imageManager->getRepository()->maxPositionByToken($token, $class);
        }
        return $max;
    }

    /**
     * @param int $id
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function remove(int $id): void
    {
        $image = $this->imageManager->getRepository()->findOne($id);
        $this->notFoundHttpException($image);
        if ($image->isMain()) {
            throw new DomainException('Unable to delete model is main');
        }
        $file = $this->imageManager->getPath() . '/' . $image->src;
        if (file_exists($file) && !unlink($file)) {
            throw new RuntimeException('Unable to unlink file');
        };
        $this->delete($image);
    }

    /**
     * @param Image $image
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete(Image $image): void
    {
        if (!$image->delete()) {
            throw new RuntimeException('Unable to delete model');
        }
    }

    /**
     * @param Image $model
     */
    public function save(Image $model)
    {
        if (!$model->save()) {
            throw new RuntimeException('Unable to save model');
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