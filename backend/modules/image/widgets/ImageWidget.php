<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 27.01.18
 * Time: 16:27
 */

namespace backend\modules\image\widgets;


use backend\modules\image\models\ImageRepository;
use backend\modules\image\services\ImageManager;
use backend\modules\image\types\ImageType;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\db\ActiveRecord;

/**
 * Class ImageWidget
 * @package backend\modules\image\widgets
 */
class ImageWidget extends Widget
{
    /**
     * @var ImageRepository
     */
    private $imageRepository;

    /** @var ActiveRecord */
    public $model;

    /** @var array */
    private $action;

    /** @var array */
    private $images;

    /**
     * ImageWidget constructor.
     * @param ImageRepository $imageRepository
     * @param array $config
     */
    public function __construct(
        ImageRepository $imageRepository,
        array $config = []
    )
    {
        $this->imageRepository = $imageRepository;
        parent::__construct($config);
    }

    /**
     * @throws InvalidConfigException
     * @throws \yii\base\Exception
     */
    public function init()
    {
        parent::init();
        if (is_null($this->model)) {
            throw new InvalidConfigException(static::class . '::model must be set');
        }
        if (!$this->model instanceof ActiveRecord) {
            throw new InvalidConfigException(static::class . '::model must be set ' . ActiveRecord::class);
        }
        /** @var ImageManager $imageManager */
        $imageManager = \Yii::createObject('image');

        if ($this->model->isNewRecord) {
            $this->action = ['/image/image/create-by-token', 'class' => $this->model::className()];
            $token = $imageManager->createToken();
            $this->images = $imageManager->wrap($this->imageRepository->findByTokenClass($token, $this->model::className()));
        } else {
            $this->action = ['/image/image/create-by-id', 'id' => $this->model->id, 'class' => $this->model::className()];
            $this->images = $imageManager->wrap($this->imageRepository->findByRecordIdClass($this->model->id, $this->model::className()));
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $type = new ImageType();

        return $this->render('image', [
                'type' => $type,
                'action' => $this->action,
                'images' => array_chunk($this->images, 3)
            ]
        );
    }
}