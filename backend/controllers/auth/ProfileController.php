<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 12.02.18
 * Time: 22:50
 */

namespace backend\controllers\auth;


use DomainException;
use RuntimeException;
use shop\entities\repositories\Auth\ProfileRepository;
use shop\search\auth\ProfileSearch;
use shop\services\Auth\ProfileService;
use shop\services\BaseService;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class ProfileController
 * @package backend\controllers\auth
 */
class ProfileController extends Controller
{
    /**
     * @var ProfileService
     */
    private $profileService;
    /**
     * @var ProfileRepository
     */
    private $profileRepository;
    /**
     * @var BaseService
     */
    private $baseService;

    /**
     * ProfileController constructor.
     * @param string $id
     * @param Module $module
     * @param ProfileService $profileService
     * @param ProfileRepository $profileRepository
     * @param BaseService $baseService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        ProfileService $profileService,
        ProfileRepository $profileRepository,
        BaseService $baseService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->profileService = $profileService;
        $this->profileRepository = $profileRepository;
        $this->baseService = $baseService;
    }


    /**
     * @return string
     */
    public function actionIndex()
    {
        $filterModel = new ProfileSearch();

        $dataProvider = $filterModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', ['dataProvider' => $dataProvider, 'filterModel' => $filterModel]);
    }

    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->profileRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);

        $type = $this->profileService->createType($model);

        if (Yii::$app->request->isPost && $type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->profileService->edit($id, $type);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('warning', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('warning', 'Runtime error');
            }
        }

        return $this->render('update', ['type' => $type]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $model = $this->profileRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);

        return $this->render('view', ['model' => $model]);
    }
}