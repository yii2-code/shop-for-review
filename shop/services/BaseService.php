<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 20:51
 */

namespace shop\services;


use DomainException;
use RuntimeException;
use yii\db\ActiveRecord;

/**
 * Class BaseService
 * @package shop\services
 */
class BaseService
{
    /**
     * @param ActiveRecord|null $model
     * @param string $message
     */
    public function domainException(ActiveRecord $model = null, string $message = 'Domain error'): void
    {
        if (is_null($model)) {
            throw new DomainException($message);
        }
    }

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