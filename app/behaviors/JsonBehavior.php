<?php
/**
 * Created by PhpStorm.
 * User: krok
 * Date: 27.01.16
 * Time: 18:00
 */

namespace app\behaviors;

use yii\base\Behavior;
use yii\base\InvalidConfigException;
use yii\db\ActiveRecord;
use yii\helpers\Json;

/**
 * Class JsonBehavior
 *
 * ```php
 * public function behaviors()
 * {
 *      return [
 *          'JsonBehavior' => [
 *              'class' => JsonBehavior::className(),
 *              'attribute' => 'attribute',
 *          ],
 *      ];
 * }
 * ```
 *
 *
 * @package behaviors
 */
class JsonBehavior extends Behavior
{
    /**
     * @var string
     */
    public $attribute;

    /**
     * @var array
     */
    public $events = [];

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (is_null($this->attribute)) {
            throw new InvalidConfigException(static::class . '::attribute must be set');
        }
    }


    /**
     * @return array
     */
    public function events()
    {
        if (empty($this->events)) {
            return [
                ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
                ActiveRecord::EVENT_AFTER_REFRESH => 'afterFind',
                ActiveRecord::EVENT_BEFORE_INSERT => 'beforeInsert',
                ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeInsert',
            ];
        } else {
            return $this->events;
        }
    }

    /**
     * @param \yii\base\Event $event
     */
    public function afterFind($event)
    {
        $event->sender->{$this->attribute} = Json::decode($event->sender->{$this->attribute});
    }

    /**
     * @param \yii\base\Event $event
     */
    public function beforeInsert($event)
    {
        $event->sender->{$this->attribute} = Json::encode($event->sender->{$this->attribute});
    }
}
