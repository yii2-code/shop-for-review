<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 15:55
 */

namespace backend\modules\image\controllers;

use backend\modules\image\models\ImageRepository;
use backend\modules\image\services\ImageManager;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class ImageController
 * @package backend\modules\image\controller
 */
class ImageController extends Controller
{
    /**
     * @var ImageManager
     */
    public $imageManager;
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /**
     * ImageController constructor.
     * @param string $id
     * @param Module $module
     * @param ImageRepository $imageRepository
     * @param array $config
     * @throws \yii\base\InvalidConfigException
     */
    public function __construct(
        string $id,
        Module $module,
        ImageRepository $imageRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->imageManager = \Yii::createObject('image');
        $this->imageRepository = $imageRepository;
    }

    /**
     * @param int $id
     * @param string $class
     * @return string
     */
    public function actionCreateById(int $id, string $class)
    {
        $service = $this->imageManager->createService();
        $type = $service->createType();
        if ($type->load(\Yii::$app->request->post()) && $service->validate($type)) {
            try {
                $service->creates($type->image, $class, $id);
            } catch (\DomainException $exception) {
                \Yii::$app->session->addFlash('warning', $exception->getMessage());
            } catch (\RuntimeException $exception) {
                \Yii::$app->errorHandler->logException($exception);
                \Yii::$app->session->addFlash('warning', 'Runtime error');
            }
        }

        $images = $this->imageManager->wrap($this->imageRepository->findByRecordIdClass($id, $class));

        return $this->renderAjax(
            'gallery',
            ['images' => array_chunk($images, 3)]
        );
    }

    /**
     * @param string $class
     * @return string
     * @throws \yii\base\Exception
     */
    public function actionCreateByToken(string $class)
    {
        $service = $this->imageManager->createService();

        $type = $service->createType();
        if ($type->load(\Yii::$app->request->post()) && $service->validate($type)) {
            try {
                $service->creates($type->image, $class);
            } catch (\DomainException $exception) {
                \Yii::$app->session->addFlash('warning', $exception->getMessage());
            } catch (\RuntimeException $exception) {
                \Yii::$app->errorHandler->logException($exception);
                \Yii::$app->session->addFlash('warning', 'Runtime error');
            }
        }
        $token = $this->imageManager->createToken();
        $images = $this->imageManager->wrap($this->imageRepository->findByTokenClass($token, $class));

        return $this->renderAjax(
            'gallery',
            ['images' => array_chunk($images, 3)]
        );
    }
}