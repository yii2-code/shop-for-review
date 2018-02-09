<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.02.18
 * Time: 17:04
 */

namespace frontend\controllers\product;


use shop\entities\Product\Product;
use shop\entities\repositories\Product\CategoryRepository;
use shop\entities\repositories\Product\ProductRepository;
use shop\services\BaseService;
use yii\base\Module;
use yii\caching\TagDependency;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
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
     * CategoryController constructor.
     * @param string $id
     * @param Module $module
     * @param CategoryRepository $categoryRepository
     * @param BaseService $baseService
     * @param ProductRepository $productRepository
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        CategoryRepository $categoryRepository,
        BaseService $baseService,
        ProductRepository $productRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->categoryRepository = $categoryRepository;
        $this->baseService = $baseService;
        $this->productRepository = $productRepository;
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

        $key = [
            __CLASS__,
            __METHOD__,
            __LINE__,
            $id
        ];

        $dependency = new TagDependency([
            'tags' => [
                Product::class,
            ],
        ]);

        list($dataProvider, $parents) = \Yii::$app->cache->getOrSet($key, function () use ($category) : array {

            $categoryIds = array_merge([$category->id], ArrayHelper::getColumn($category->getDescendants()->all(), 'id'));
            $query = $this->productRepository->queryByCategoryMains($categoryIds);

            $parents = $category->getParents()->notRoot()->all();

            $dataProvider = new ActiveDataProvider([
                'query' => $query
            ]);
            return [$dataProvider, $parents];
        }, null, $dependency);


        return $this->render('index', ['dataProvider' => $dataProvider, 'parents' => $parents, 'category' => $category]);
    }
}