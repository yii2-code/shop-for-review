<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 12:29
 */

namespace app\modules\tag\types;


use yii\base\Model;

/**
 * Class TagType
 * @package app\modules\tag\types
 */
class TagType extends Model
{
    /**
     * @var
     */
    public $tag;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['tag', 'required'],
            ['tag', 'string', 'max' => 100],
            ['tag', 'trim'],
        ];
    }
}