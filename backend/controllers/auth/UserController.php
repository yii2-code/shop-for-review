<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 11.02.18
 * Time: 22:00
 */

namespace backend\controllers\auth;


use DomainException;
use RuntimeException;
use shop\entities\repositories\Auth\UserRepository;
use shop\search\UserSearch;
use shop\services\Auth\UserService;
use shop\services\BaseService;
use shop\types\Auth\UserType;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class UserController
 * @package backend\controllers\auth
 */
class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     * @param string $id
     * @param Module $module
     * @param UserService $userService
     * @param UserRepository $userRepository
     * @param BaseService $baseService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        UserService $userService,
        UserRepository $userRepository,
        BaseService $baseService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
        $this->baseService = $baseService;
        $this->userRepository = $userRepository;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $filterModel = new UserSearch();
        $dataProvider = $filterModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', ['dataProvider' => $dataProvider, 'filterModel' => $filterModel]);
    }

    /**
     * @return string
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function actionCreate()
    {
        $type = new UserType();

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->userService->create($type);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('warning', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('warning', 'Runtime error');
            }
        }

        return $this->render('create', ['type' => $type]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView(int $id)
    {
        $model = $this->userRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);

        return $this->render('view', ['model' => $model]);
    }


    /**
     * @param int $id
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->userRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);

        $type = new UserType($model);


        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->userService->edit($id, $type);
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
}