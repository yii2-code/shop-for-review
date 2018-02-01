<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 01.02.18
 * Time: 20:04
 */

namespace backend\controllers\product;

use DomainException;
use RuntimeException;
use shop\entities\repositories\Product\CharacteristicRepository;
use shop\search\CharacteristicSearch;
use shop\services\BaseService;
use shop\services\Product\CharacteristicService;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class CharacteristicController
 * @package backend\controllers\product
 */
class CharacteristicController extends Controller
{
    /**
     * @var CharacteristicRepository
     */
    private $characteristicRepository;
    /**
     * @var CharacteristicService
     */
    private $characteristicService;
    /**
     * @var BaseService
     */
    private $baseService;


    /**
     * CharacteristicController constructor.
     * @param string $id
     * @param Module $module
     * @param CharacteristicRepository $characteristicRepository
     * @param CharacteristicService $characteristicService
     * @param BaseService $baseService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        CharacteristicRepository $characteristicRepository,
        CharacteristicService $characteristicService,
        BaseService $baseService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->characteristicRepository = $characteristicRepository;
        $this->characteristicService = $characteristicService;
        $this->baseService = $baseService;
    }


    /**
     * @return string
     */
    public function actionIndex()
    {
        $filterModel = new CharacteristicSearch();

        $dataProvider = $filterModel->search(Yii::$app->request->queryParams);

        return $this->render('index', ['dataProvider' => $dataProvider, 'filterModel' => $filterModel]);
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $type = $this->characteristicService->createType();
        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->characteristicService->create($type);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('waring', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('waring', 'Runtime exception');
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
        $model = $this->characteristicRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->characteristicRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);

        $type = $this->characteristicService->createType($model);
        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->characteristicService->edit($id, $type);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('waring', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('waring', 'Runtime exception');
            }
        }
        return $this->render('create', ['type' => $type]);
    }
}