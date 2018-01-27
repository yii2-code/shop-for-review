<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 14:25
 */

declare(strict_types=1);

namespace backend\modules\image\services;


use backend\modules\image\models\Image;
use backend\modules\image\models\ImageRepository;
use backend\modules\image\TDO\ImageTdo;
use RuntimeException;
use Yii;

/**
 * Class ImageManager
 * @package backend\modules\image\services
 */
class ImageManager
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;
    /**
     * @var string
     */
    private $path;
    /**
     * @var string
     */
    private $url;

    /**
     * @var int
     */
    public $maxFiles;
    /**
     * @var string
     */
    private $identitySession = '_image_token';

    /**
     * ImageManager constructor.
     * @param ImageRepository $imageRepository
     * @param string $path
     * @param string $url
     * @param string $identitySession
     * @param int $maxFiles
     */
    public function __construct(
        ImageRepository $imageRepository,
        string $path,
        string $url,
        string $identitySession,
        int $maxFiles = 1
    )
    {
        $this->imageRepository = $imageRepository;
        $this->path = rtrim($path, '/');
        $this->url = $url;
        $this->identitySession = $identitySession;
        $this->maxFiles = $maxFiles;
    }

    /**
     * @return ImageService
     */
    public function createService()
    {
        return new ImageService($this);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function createToken(): string
    {
        if (Yii::$app->session->has($this->identitySession)) {
            return Yii::$app->session->get($this->identitySession);
        } else {
            $token = Yii::$app->security->generateRandomString(64);
            Yii::$app->session->set($this->identitySession, $token);
            return $token;
        }
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        if (!Yii::$app->session->has($this->identitySession)) {
            throw new RuntimeException('Enable to get token');
        }
        return Yii::$app->session->get($this->identitySession);
    }

    /**
     * @return string
     */
    public function getIdentitySession(): string
    {
        return $this->identitySession;
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
    public function getPath(): string
    {
        return $this->path;
    }


    /**
     * @param string $class
     * @return array|Image[]
     */
    public function getImagesByToken(string $class): array
    {
        $token = $this->getToken();
        return $this->imageRepository->findByTokenClass($token, $class);
    }


    /**
     * @param int $id
     * @param string $class
     * @return array|Image[]
     */
    public function getImageById(int $id, string $class): array
    {
        return $this->imageRepository->findByRecordIdClass($id, $class);
    }

    /**
     * @param int $id
     * @param string $class
     * @return array|ImageTdo[]
     */
    public function getImageTdoById(int $id, string $class): array
    {
        return $this->wrap($this->getImageById($id, $class));
    }

    /**
     * @param string $class
     * @return array|ImageTdo[]
     */
    public function getImageTdoByToken(string $class): array
    {
        return $this->wrap($this->getImagesByToken($class));
    }

    /**
     * @param array|Image[] $images
     * @return array|ImageTdo[]
     */
    public function wrap(array $images): array
    {
        $wrap = [];
        foreach ($images as $image) {
            $wrap[] = new ImageTdo($image, $this);
        }
        return $wrap;
    }
}