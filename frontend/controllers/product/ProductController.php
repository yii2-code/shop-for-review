<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 12.02.18
 * Time: 21:44
 */

namespace frontend\controllers\product;


use shop\entities\repositories\Product\ProductRepository;
use shop\services\BaseService;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class ProductController
 * @package frontend\controllers\product
 */
class ProductController extends Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var BaseService
     */
    private $baseService;

    /**
     * ProductController constructor.
     * @param string $id
     * @param Module $module
     * @param ProductRepository $productRepository
     * @param BaseService $baseService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        ProductRepository $productRepository,
        BaseService $baseService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->productRepository = $productRepository;
        $this->baseService = $baseService;
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

        $category = $model->categoryMain;
        $parents = $category->getParents()->notRoot()->all();

        return $this->render('view', ['model' => $model, 'parents' => $parents]);
    }
}