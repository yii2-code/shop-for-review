<?php

$dotenv = new \Symfony\Component\Dotenv\Dotenv();

$dotenv->load(__DIR__ . '/../../.env');

Yii::setAlias('@common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('@shop', realpath(__DIR__ . '/../../shop'));
Yii::setAlias('@static', realpath(__DIR__ . '/../../static'));