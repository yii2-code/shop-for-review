<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.02.18
 * Time: 17:04
 */

namespace frontend\controllers\product;

use shop\entities\read\ProductRead;
use shop\entities\repositories\Product\CategoryRepository;
use shop\entities\repositories\Product\ProductRepository;
use shop\services\BaseService;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class CategoryController
 * @package frontend\controllers\product
 */
class CategoryController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var ProductRead
     */
    private $productRead;

    /**
     * CategoryController constructor.
     * @param string $id
     * @param Module $module
     * @param CategoryRepository $categoryRepository
     * @param BaseService $baseService
     * @param ProductRepository $productRepository
     * @param ProductRead $productRead
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        CategoryRepository $categoryRepository,
        BaseService $baseService,
        ProductRepository $productRepository,
        ProductRead $productRead,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->categoryRepository = $categoryRepository;
        $this->baseService = $baseService;
        $this->productRepository = $productRepository;
        $this->productRead = $productRead;
    }

    /**
     * @param int $id
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionIndex(int $id)
    {
        $category = $this->categoryRepository->findOne($id);
        $this->baseService->notFoundHttpException($category);

        $parents = $category->getParents()->notRoot()->all();

        $dataProvider = $this->productRead->findAllByCategory($category);

        return $this->render('index', ['dataProvider' => $dataProvider, 'parents' => $parents, 'category' => $category]);
    }
}