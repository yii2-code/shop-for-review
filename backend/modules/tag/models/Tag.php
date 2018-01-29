<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 29.01.18
 * Time: 15:23
 */

namespace backend\modules\tag\models;


use yii\db\ActiveRecord;

/**
 * Class Tag
 * @package backend\modules\tag\models
 * @property $id int
 * @property $name int
 */
class Tag extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%tag}}';
    }
}