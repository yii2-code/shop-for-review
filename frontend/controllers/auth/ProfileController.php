<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 14:46
 */

namespace frontend\controllers\auth;


use DomainException;
use RuntimeException;
use shop\entities\repositories\Auth\ProfileRepository;
use shop\services\Auth\ProfileService;
use shop\services\BaseService;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class ProfileController
 * @package frontend\controllers\auth
 */
class ProfileController extends Controller
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var ProfileRepository
     */
    private $profileRepository;
    /**
     * @var ProfileService
     */
    private $profileService;

    /**
     * ProfileController constructor.
     * @param string $id
     * @param Module $module
     * @param BaseService $baseService
     * @param ProfileRepository $profileRepository
     * @param ProfileService $profileService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        BaseService $baseService,
        ProfileRepository $profileRepository,
        ProfileService $profileService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->baseService = $baseService;
        $this->profileRepository = $profileRepository;
        $this->profileService = $profileService;
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->profileRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);

        $type = $this->profileService->createType($model);

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $this->profileService->edit($id, $type);
                Yii::$app->session->addFlash('info', 'The profile was updated');
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('warning', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('warning', 'Runtime error');
            }
        }

        return $this->render('update', ['type' => $type]);
    }
}