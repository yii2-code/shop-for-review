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
use DomainException;
use RuntimeException;
use Yii;
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

        $this->imageManager = Yii::createObject(\backend\modules\image\Module::IMAGE);
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
        $warning = null;

        if ($type->load(Yii::$app->request->post()) && $service->validate($type)) {
            try {
                $service->creates($type->image, $class, $id);
            } catch (DomainException $exception) {
                $warning = $exception->getMessage();
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                $warning = 'Runtime error';
            }
        }

        $images = $this->imageManager->getImageTdoByRecordId($id, $class);

        return $this->renderAjax(
            'gallery',
            ['images' => array_chunk($images, 3), 'warning' => $warning]
        );
    }

    /**
     * @param string $class
     * @return string
     */
    public function actionCreateByToken(string $class)
    {
        $service = $this->imageManager->createService();
        $type = $service->createType();

        $warning = null;
        if ($type->load(Yii::$app->request->post()) && $service->validate($type)) {
            try {
                $service->creates($type->image, $class);
            } catch (DomainException $exception) {
                $warning = $exception->getMessage();
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                $warning = 'Runtime error';
            }
        }

        $images = $this->imageManager->getImageTdoByToken($class);

        return $this->renderAjax(
            'gallery',
            ['images' => array_chunk($images, 3), 'warning' => $warning]
        );
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {

        $service = $this->imageManager->createService();
        $image = $this->imageManager->getRepository()->findOne($id);
        $service->notFoundHttpException($image);
        $type = $service->createUpdateType();
        $message = null;

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $service->edit($id, $type);
                $message = 'Success';
            } catch (DomainException $exception) {
                $message = $exception->getMessage();
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                $message = 'Runtime error';
            }
        }

        $images = $this->getImage($image->class, $image->record_id);


        return $this->renderAjax(
            'gallery',
            ['images' => array_chunk($images, 3), 'id' => $id, 'message' => $message]
        );
    }

    /**
     * @param int $id
     * @return string
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete(int $id)
    {
        $service = $this->imageManager->createService();
        $image = $this->imageManager->getRepository()->findOne($id);
        $service->notFoundHttpException($image);
        $recordId = $image->record_id;
        $class = $image->class;
        $message = null;

        try {
            $service->remove($id);
        } catch (DomainException $exception) {
            $message = $exception->getMessage();
        } catch (RuntimeException $exception) {
            Yii::$app->errorHandler->logException($exception);
            $message = 'Runtime error';
        }

        $images = $this->getImage($class, $recordId);

        return $this->renderAjax(
            'gallery',
            ['images' => array_chunk($images, 3), 'id' => $id, 'message' => $message]
        );
    }


    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionMoveUp(int $id)
    {
        $service = $this->imageManager->createService();
        $image = $this->imageManager->getRepository()->findOne($id);
        $service->notFoundHttpException($image);

        try {
            $service->moveUp($id);
            $message = 'Success';
        } catch (DomainException $exception) {
            $message = $exception->getMessage();
        } catch (RuntimeException $exception) {
            Yii::$app->errorHandler->logException($exception);
            $message = 'Runtime error';
        }

        $images = $this->getImage($image->class, $image->record_id);

        return $this->renderAjax(
            'gallery',
            ['images' => array_chunk($images, 3), 'id' => $id, 'message' => $message]
        );
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionMoveDown(int $id)
    {
        $service = $this->imageManager->createService();
        $image = $this->imageManager->getRepository()->findOne($id);
        $service->notFoundHttpException($image);

        try {
            $service->moveDown($id);
            $message = 'Success';
        } catch (DomainException $exception) {
            $message = $exception->getMessage();
        } catch (RuntimeException $exception) {
            Yii::$app->errorHandler->logException($exception);
            $message = 'Runtime error';
        }

        $images = $this->getImage($image->class, $image->record_id);

        return $this->renderAjax(
            'gallery',
            ['images' => array_chunk($images, 3), 'id' => $id, 'message' => $message]
        );
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionActiveMain(int $id)
    {
        $service = $this->imageManager->createService();
        $image = $this->imageManager->getRepository()->findOne($id);
        $service->notFoundHttpException($image);

        try {
            $service->updateMain($id);
            $message = 'Success';
        } catch (DomainException $exception) {
            $message = $exception->getMessage();
        } catch (RuntimeException $exception) {
            Yii::$app->errorHandler->logException($exception);
            $message = 'Runtime error';
        }

        $images = $this->getImage($image->class, $image->record_id);

        return $this->renderAjax(
            'gallery',
            ['images' => array_chunk($images, 3), 'id' => $id, 'message' => $message]
        );
    }

    /**
     * @param int $record_id
     * @param string $class
     * @return array
     */
    public function getImage(string $class, int $record_id = null): array
    {
        if (is_null($record_id)) {
            $images = $this->imageManager->getImageTdoByToken($class);
        } else {
            $images = $this->imageManager->getImageTdoByRecordId($record_id, $class);
        }
        return $images;
    }
}