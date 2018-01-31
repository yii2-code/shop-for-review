<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 31.01.18
 * Time: 12:17
 */

namespace app\modules\tag\controllers\api;


use app\modules\tag\models\TagRepository;
use app\modules\tag\services\TagService;
use DomainException;
use Imagine\Exception\RuntimeException;
use Yii;
use yii\base\Module;
use yii\rest\Controller;

/**
 * Class TagController
 * @package app\modules\tag\controllers\api
 */
class TagController extends Controller
{
    /**
     * @var TagService
     */
    private $tagService;
    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * TagController constructor.
     * @param string $id
     * @param Module $module
     * @param TagService $tagService
     * @param TagRepository $tagRepository
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        TagService $tagService,
        TagRepository $tagRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->tagService = $tagService;
        $this->tagRepository = $tagRepository;
    }

    /**
     * @return array
     */
    public function actionCreate()
    {
        $response = ['status' => 'error', 'message' => 'Creating error'];
        $type = $this->tagService->createType();

        if ($type->load(Yii::$app->request->post(), '') && $type->validate()) {
            try {
                $tag = $this->tagRepository->findOneByName($type->tag);
                if (is_null($tag)) {
                    $this->tagService->create($type);
                }
                $response = ['status' => 'ok'];
            } catch (DomainException $exception) {
                ['status' => 'error', 'message' => $exception->getMessage()];
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                ['status' => 'error', 'message' => $exception->getMessage()];
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Unable to validate type'];
        }

        return $response;
    }
}