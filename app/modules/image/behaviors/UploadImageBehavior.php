<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 12:12
 */

namespace app\modules\image\behaviors;


use app\modules\image\services\Upload;
use app\modules\image\tests\stubs\UploadedFile;
use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\base\ModelEvent;
use yii\db\ActiveRecord;
use yii\db\AfterSaveEvent;

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
        $this->upload = new Upload($this->path, $this->thumbPath, $this->thumbs);
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
}