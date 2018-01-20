<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 14:43
 */

declare(strict_types=1);

namespace shop\helpers;


use Yii;

/**
 * Class UserHelper
 * @package shop\helpers
 */
class UserHelper
{

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public static function generateRequestEmail(): string
    {
        return Yii::$app->security->generateRandomString(64);
    }

    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public static function generatePasswordReset(): string
    {
        return sprintf('%s_%s', Yii::$app->security->generateRandomString(64), time());
    }
}