<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 05.02.18
 * Time: 13:47
 */

namespace app\modules\image\tests\stubs;


use app\modules\image\behaviors\UploadImageBehavior;

class ActiveRecord extends \yii\db\ActiveRecord
{
    /** @var string|null|\yii\web\UploadedFile */
    public $file;

    public function behaviors()
    {
        return [
            'UploadImageBehavior' => [
                'class' => UploadImageBehavior::class,
                'attribute' => 'file',
                'path' => codecept_output_dir('behavior'),
                'thumbPath' => codecept_output_dir('behavior/thumb'),
                'url' => '/',
                'thumbUrl' => '/thumb',
                'thumbs' => [
                    '160x160' => [
                        'width' => '160',
                        'height' => '160',
                        'quality' => '100',
                    ]
                ]
            ],
        ];
    }
}