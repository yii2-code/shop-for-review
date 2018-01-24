<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 24.01.18
 * Time: 17:15
 */

namespace backend\controllers\product;


use DomainException;
use RuntimeException;
use shop\entities\repositories\Product\CategoryRepository;
use shop\services\BaseService;
use shop\services\Product\CategoryService;
use Yii;
use yii\base\Module;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Class CategoryController
 * @package backend\controllers\product
 */
class CategoryController extends Controller
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * CategoryController constructor.
     * @param string $id
     * @param Module $module
     * @param BaseService $baseService
     * @param CategoryRepository $categoryRepository
     * @param CategoryService $categoryService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        BaseService $baseService,
        CategoryRepository $categoryRepository,
        CategoryService $categoryService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->baseService = $baseService;
        $this->categoryRepository = $categoryRepository;
        $this->categoryService = $categoryService;
    }

    /**
     *
     */
    public function actionIndex()
    {
        $root = $this->categoryRepository->findOneRoot();

        $models = $root->getDescendants();

        $dataProvider = new ActiveDataProvider([
            'query' => $models,
            'pagination' => [
                'pageSize' => 0,
            ]
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * @return string
     */
    public function actionCreate()
    {
        $type = $this->categoryService->createType();
        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->categoryService->create($type);
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
        $model = $this->categoryRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);
        return $this->render('view', ['model' => $model]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->categoryRepository->findOne($id);
        $this->baseService->notFoundHttpException($model);
        $type = $this->categoryService->createType($model);
        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->categoryService->edit((int)$id, $type);
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