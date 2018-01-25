<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 14:27
 */

namespace backend\controllers\product;


use DomainException;
use RuntimeException;
use shop\entities\repositories\Product\BrandRepository;
use shop\search\BrandSearch;
use shop\services\BaseService;
use shop\services\Product\BrandService;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class BrandController
 * @package backend\controllers\product
 */
class BrandController extends Controller
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var BrandService
     */
    private $brandService;
    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * BrandController constructor.
     * @param string $id
     * @param Module $module
     * @param BaseService $baseService
     * @param BrandService $brandService
     * @param BrandRepository $brandRepository
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        BaseService $baseService,
        BrandService $brandService,
        BrandRepository $brandRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->baseService = $baseService;
        $this->brandService = $brandService;
        $this->brandRepository = $brandRepository;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $modelSearch = new BrandSearch();
        $dataProvider = $modelSearch->search(Yii::$app->request->queryParams);

        return $this->render('index', ['dataProvider' => $dataProvider, 'modelSearch' => $modelSearch]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $type = $this->brandService->createType();
        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->brandService->create($type);
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
     * @param $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = $this->brandRepository->findOne($id);
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
        $model = $this->brandRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);

        $type = $this->brandService->createType($model);

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->brandService->edit($id, $type);
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