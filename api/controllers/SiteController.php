<?php

namespace api\controllers;


/**
 * Site controller
 */
class SiteController extends \yii\rest\Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
