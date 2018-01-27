<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 14:25
 */

declare(strict_types=1);

namespace backend\modules\image\services;


use backend\modules\image\models\ImageRepository;
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
     * @var string
     */
    private $identitySession = '_image_token';

    /**
     * ImageManager constructor.
     * @param ImageRepository $imageRepository
     * @param string $path
     * @param string $url
     * @param string $identitySession
     */
    public function __construct(
        ImageRepository $imageRepository,
        string $path,
        string $url,
        string $identitySession
    )
    {
        $this->imageRepository = $imageRepository;
        $this->path = rtrim($path, '/');
        $this->url = $url;
        $this->identitySession = $identitySession;
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
    public function getPath(): string
    {
        return $this->path;
    }
}