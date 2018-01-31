<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 13:15
 */

declare(strict_types=1);

namespace app\modules\tag\services;

use app\modules\tag\models\TagAssign;
use app\modules\tag\models\TagRepository;
use RuntimeException;


/**
 * Class TagAssignService
 * @package app\modules\tag\services
 */
class TagAssignService
{
    /**
     * @var TagRepository
     */
    private $tagRepository;
    /**
     * @var TagService
     */
    private $tagService;

    /**
     * TagAssignService constructor.
     * @param TagRepository $tagRepository
     * @param TagService $tagService
     */
    public function __construct(
        TagRepository $tagRepository,
        TagService $tagService
    )
    {
        $this->tagRepository = $tagRepository;
        $this->tagService = $tagService;
    }


    /**
     * @param string $class
     * @param int $recordId
     * @param array $names
     */
    public function assign(string $class, int $recordId, array $names)
    {
        $names = $this->tagService->filter($names);
        TagAssign::deleteAll(['class' => $class, 'record_id' => $recordId]);
        if (empty($names)) {
            return;
        }
        $tags = $this->tagRepository->findByNames($names);

        foreach ($tags as $tag) {
            $tagAssign = TagAssign::create($class, $recordId, $tag->id);
            $this->save($tagAssign);
        }
    }

    /**
     * @param TagAssign $model
     */
    public function save(TagAssign $model)
    {
        if (!$model->save()) {
            throw new RuntimeException('Unable to save model');
        }
    }
}