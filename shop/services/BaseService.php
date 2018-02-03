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
use shop\entities\Auth\User;
use Yii;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

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
     * @param ActiveRecord|null $model
     * @throws NotFoundHttpException
     */
    public function notFoundHttpException(ActiveRecord $model = null)
    {
        if (is_null($model)) {
            throw new NotFoundHttpException(Yii::t('shop', 'The required page does not exist'));
        }
    }

    /**
     * @param User $model
     */
    public function login(User $model): void
    {
        if (!Yii::$app->user->login($model)) {
            throw new RuntimeException('Login error');
        }
    }

    /**
     * @param ActiveRecord $model
     */
    public function save(ActiveRecord $model)
    {
        if (!$model->save()) {
            throw new RuntimeException(Yii::t('shop', 'Unable to save model'));
        }
    }


    /**
     * @param ActiveRecord $model
     * @throws \Exception
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function delete(ActiveRecord $model)
    {
        if (!$model->delete()) {
            throw new RuntimeException(Yii::t('shop', 'Unable to delete model'));
        }
    }
}