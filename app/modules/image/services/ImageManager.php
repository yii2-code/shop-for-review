<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 14:25
 */

declare(strict_types=1);

namespace app\modules\image\services;


use app\modules\image\models\Image;
use app\modules\image\models\ImageRepository;
use app\modules\image\TDO\ImageTdo;
use RuntimeException;
use Yii;

/**
 * Class ImageManager
 * @package app\modules\image\services
 */
class ImageManager implements ImageManagerInterface
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

    private $maxFiles;
    /**
     * @var string
     */
    private $identitySession = '_image_token';


    /**
     * @var string
     */
    private $thumbPath;

    /**
     * @var string
     */
    private $thumbUrl;

    /**
     * @var array
     */
    private $thumbs = [
        '600x400' => [
            'weight' => 600,
            'height' => 400,
            'quality' => 100,
        ],
    ];

    /**
     * ImageManager constructor.
     * @param ImageRepository $imageRepository
     * @param string $path
     * @param string $url
     * @param string $thumbPath
     * @param string $thumbUrl
     * @param array $thumbs
     * @param string $identitySession
     * @param int $maxFiles
     */
    public function __construct(
        ImageRepository $imageRepository,
        string $path,
        string $url,
        string $thumbPath,
        string $thumbUrl,
        string $identitySession,
        int $maxFiles = 1,
        array $thumbs = []
    )
    {
        $this->imageRepository = $imageRepository;
        $this->path = rtrim($path, '/');
        $this->url = rtrim($url, '/');
        $this->identitySession = $identitySession;
        $this->maxFiles = $maxFiles;
        $this->thumbUrl = rtrim($thumbUrl, '/');
        $this->thumbPath = rtrim($thumbPath, '/');
        $this->thumbs = array_merge($this->thumbs, $thumbs);
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
     * @return ImageRepository
     */
    public function getRepository(): ImageRepository
    {
        return $this->imageRepository;
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
     * @return string
     */
    public function getThumbPath(): string
    {
        return $this->thumbPath;
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

    /**
     * @return int
     */
    public function getMaxFiles(): int
    {
        return $this->maxFiles;
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
     * @param string $class
     * @param int|null $recordId
     * @param int $sort
     * @return array|Image[]
     */
    public function getImages(string $class, int $recordId = null, $sort = SORT_DESC): array
    {
        if (is_null($recordId)) {
            return $this->getImagesByToken($class, $sort);
        } else {
            return $this->getImageByRecordId($recordId, $class, $sort);
        }
    }

    /**
     * @param string $class
     * @return array|Image[]
     */
    public function getImagesByToken(string $class, $sort = SORT_DESC): array
    {
        $token = $this->getToken();
        return $this->imageRepository->findByTokenClass($token, $class, $sort);
    }


    /**
     * @param int $id
     * @param string $class
     * @param int $sort
     * @return array|Image[]
     */
    public function getImageByRecordId(int $id, string $class, $sort = SORT_DESC): array
    {
        return $this->imageRepository->findByRecordIdClass($id, $class, $sort);
    }

    /**
     * @param int $id
     * @param string $class
     * @return array|ImageTdo[]
     */
    public function getImageTdoByRecordId(int $id, string $class): array
    {
        return $this->wrap($this->getImageByRecordId($id, $class));
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
     * @param string $class
     * @return array
     */
    public function getActionForToken(string $class): array
    {
        return ['/image/image/create-by-token', 'class' => $class];
    }

    /**
     * @param int $id
     * @param string $class
     * @return array
     */
    public function getActionForId(int $id, string $class): array
    {
        return ['/image/image/create-by-id', 'id' => $id, 'class' => $class];
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