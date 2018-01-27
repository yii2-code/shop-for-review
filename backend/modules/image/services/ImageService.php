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
use RuntimeException;
use yii\helpers\FileHelper;
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
     * @param Image $model
     */
    public function save(Image $model)
    {
        if (!$model->save()) {
            throw new RuntimeException('Saving error');
        }
    }
}