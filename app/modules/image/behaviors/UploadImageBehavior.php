<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 12:12
 */

namespace app\modules\image\behaviors;


use app\modules\image\helper\ImageHelper;
use app\modules\image\services\Config;
use app\modules\image\services\Upload;
use app\modules\image\services\View;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;
use yii\web\UploadedFile;

/**
 * Class UploadImageBehavior
 * @package app\modules\image\behaviors
 */
class UploadImageBehavior extends Behavior
{
    /**
     * @var
     */
    public $attribute;
    /**
     * @var
     */
    public $path;
    /**
     * @var
     */
    public $thumbPath;
    /**
     * @var
     */
    public $url;
    /**
     * @var
     */
    public $thumbUrl;
    /**
     * @var array
     */
    public $thumbs = [];

    /** @var Upload */
    protected $upload;

    /** @var Config */
    private $config;

    /** @var View */
    private $view;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (is_null($this->attribute)) {
            throw new InvalidConfigException(static::class . '::attribute must be set');
        }
        if (is_null($this->path)) {
            throw new InvalidConfigException(static::class . '::path must be set');
        }
        if (is_null($this->thumbPath)) {
            throw new InvalidConfigException(static::class . '::thumbPath must be set');
        }
        if (is_null($this->url)) {
            throw new InvalidConfigException(static::class . '::url must be set');
        }
        if (is_null($this->thumbUrl)) {
            throw new InvalidConfigException(static::class . '::thumbUrl must be set');
        }
        $this->config = new Config($this->path, $this->thumbPath, $this->url, $this->thumbUrl, $this->thumbs);
        $this->upload = new Upload($this->config);
        $this->view = new View($this->config, $this->upload);
    }

    /**
     * @return array
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeUpdate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
        ];
    }

    /**
     * @param ModelEvent $event
     */
    public function beforeInsert(ModelEvent $event)
    {
        $model = $event->sender;
        $file = $model->{$this->attribute};
        if ($file instanceof UploadedFile) {
            $model->{$this->attribute} = $this->upload->upload($file);
            $this->upload->createThumbs($model->{$this->attribute});
        }
    }

    /**
     * @param ModelEvent $event
     */
    public function beforeUpdate(ModelEvent $event)
    {
        /** @var ActiveRecord $model */
        $model = $event->sender;
        $file = $model->{$this->attribute};
        if ($file instanceof UploadedFile) {
            $model->{$this->attribute} = $this->upload->upload($file);
            $this->upload->createThumbs($model->{$this->attribute});
        } else {
            unset($model->{$this->attribute});
        }
    }

    /**
     * @param AfterSaveEvent $event
     */
    public function afterUpdate(AfterSaveEvent $event)
    {
        if (isset($event->changedAttributes[$this->attribute])) {
            $old = $event->changedAttributes[$this->attribute];
            if (!empty($old)) {
                $this->upload->unlink($old);
            }
        }
    }

    /**
     * @param string $thumb
     * @return string
     */
    public function getThumbUrl(string $thumb)
    {
        if ($this->view->isThumbFile($thumb, $this->owner->{$this->attribute})) {
            return $this->config->getThumbUrl() . ImageHelper::constructThumbName($thumb, $this->owner->{$this->attribute});
        }
    }
}