<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 26.01.18
 * Time: 13:39
 */

namespace backend\controllers\product;


use DomainException;
use RuntimeException;
use shop\entities\repositories\Product\ProductRepository;
use shop\search\ProductSearch;
use shop\services\BaseService;
use shop\services\Product\ProductService;
use shop\types\Product\PriceType;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class ProductController
 * @package backend\controllers\product
 */
class ProductController extends Controller
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var ProductService
     */
    private $productService;

    /**
     * ProductController constructor.
     * @param string $id
     * @param Module $module
     * @param BaseService $baseService
     * @param ProductRepository $productRepository
     * @param ProductService $productService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        BaseService $baseService,
        ProductRepository $productRepository,
        ProductService $productService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->baseService = $baseService;
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $type = $this->productService->createType();

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->productService->create($type, $type->price);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('waring', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('waring', 'Runtime error');
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
        $model = $this->productRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);
        $type = new PriceType($model);
        return $this->render('view', ['model' => $model, 'type' => $type]);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionEditPrice(int $id)
    {
        $type = new PriceType();
        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $this->productService->editPrice($id, $type);
                Yii::$app->session->addFlash('info', 'The price is updated');
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('waring', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('waring', 'Runtime error');
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->productRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);
        $type = $this->productService->createType($model);
        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->productService->edit($id, $type);
                return $this->redirect(['view', 'id' => $model->id]);
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('waring', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('waring', 'Runtime error');
            }
        }

        return $this->render('update', ['type' => $type]);
    }
}