<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 29.01.18
 * Time: 17:03
 */

namespace app\modules\tag\models;


use DomainException;
use yii\db\ActiveRecord;

/**
 * Class TagAssign
 * @package app\modules\tag\models
 * @property $id int
 * @property $class string
 * @property $record_id int
 * @property $tag_id int
 */
class TagAssign extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%tag_assign}}';
    }

    /**
     * @return TagAssignQuery
     */
    public static function find(): TagAssignQuery
    {
        return new TagAssignQuery(static::class);
    }

    /**
     * @param string $class
     * @param int $recordId
     * @param int $tagId
     * @return TagAssign
     */
    public static function create(string $class, int $recordId, int $tagId): TagAssign
    {
        $repository = new TagRepository();

        if (!$repository->existsById($tagId)) {
            throw new DomainException('Unable to create tag assign because tag not found');
        }
        $model = new static();
        $model->class = $class;
        $model->record_id = $recordId;
        $model->tag_id = $tagId;
        return $model;
    }
}