<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 21:07
 */

namespace app\modules\image\types;


use yii\base\Model;

/**
 * Class ImageType
 * @package app\modules\image\types
 */
class ImageType extends Model
{
    /**
     * @var
     */
    public $image;

    /**
     * @var int
     */
    public $maxFiles;

    /**
     * ImageType constructor.
     * @param int $maxFiles
     * @param array $config
     */
    public function __construct(
        $maxFiles = 1,
        array $config = []
    )
    {
        $this->maxFiles = $maxFiles;
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [
                'image',
                'image',
                'mimeTypes' => 'image/*',
                'maxFiles' => $this->maxFiles,
                'skipOnEmpty' => false,
            ]
        ];
    }
}