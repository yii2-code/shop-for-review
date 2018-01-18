<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 20:51
 */

namespace shop\services;


use RuntimeException;
use yii\db\ActiveRecord;

/**
 * Class BaseService
 * @package shop\services
 */
class BaseService
{
    /**
     * @param ActiveRecord $model
     */
    public function save(ActiveRecord $model)
    {
        if (!$model->save()) {
            throw new RuntimeException('Saving error');
        }
    }
}