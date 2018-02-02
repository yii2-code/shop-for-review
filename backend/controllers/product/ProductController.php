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
use shop\entities\repositories\Product\ValueRepository;
use shop\search\ProductSearch;
use shop\services\BaseService;
use shop\services\Product\ProductService;
use shop\services\Product\ValueService;
use shop\types\Product\PriceType;
use Yii;
use yii\base\Model;
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
     * @var ValueService
     */
    private $valueService;
    /**
     * @var ValueRepository
     */
    private $valueRepository;

    /**
     * ProductController constructor.
     * @param string $id
     * @param Module $module
     * @param BaseService $baseService
     * @param ProductRepository $productRepository
     * @param ProductService $productService
     * @param ValueRepository $valueRepository
     * @param ValueService $valueService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        BaseService $baseService,
        ProductRepository $productRepository,
        ProductService $productService,
        ValueRepository $valueRepository,
        ValueService $valueService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->baseService = $baseService;
        $this->productRepository = $productRepository;
        $this->productService = $productService;
        $this->valueRepository = $valueRepository;
        $this->valueService = $valueService;
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
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $type = $this->productService->createType();

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->productService->create($type, $type->price, $type->values);
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
        $update = $this->productRepository->findOne($id);
        $this->baseService->notFoundHttpException($update);

        $type = new PriceType($update);

        $updateValues = $this->valueService->createTypes($update);

        return $this->render('view',
            ['model' => $update, 'type' => $type, 'updateValues' => $updateValues]
        );
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
     * @return \yii\web\Response
     * @throws \Exception
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionEditValue(int $id)
    {
        $update = $this->productRepository->findOne($id);
        $this->baseService->notFoundHttpException($update);
        $valueTypes = $this->valueService->createTypes($update);
        if (Model::loadMultiple($valueTypes, Yii::$app->request->post()) && Model::validateMultiple($valueTypes)) {
            try {
                $this->valueService->edits($id, $valueTypes);
                Yii::$app->session->addFlash('info', 'The value is characteristics');
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('waring', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('waring', 'Runtime error');
            }
        } else {
            foreach ($valueTypes as $valueType) {
                if ($valueType->hasErrors('value')) {
                    Yii::$app->session->addFlash('info', $valueType->getFirstError('value'));
                }
            }
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
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