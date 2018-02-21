<?php
/**
 * Created by PhpStorm.
 * User: cherem
 * Date: 20.02.18
 * Time: 18:37
 */

namespace console\controllers;


use shop\entities\repositories\Product\ProductRepository;
use shop\services\search\ProductIndexer;
use yii\base\Module;
use yii\console\Controller;

/**
 * Class SearchController
 * @package console\controllers
 */
class SearchController extends Controller
{
    /**
     * @var ProductIndexer
     */
    private $productIndexer;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * SearchController constructor.
     * @param string $id
     * @param Module $module
     * @param ProductIndexer $productIndexer
     * @param ProductRepository $productRepository
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        ProductIndexer $productIndexer,
        ProductRepository $productRepository,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->productIndexer = $productIndexer;
        $this->productRepository = $productRepository;
    }

    /**
     *
     */
    public function actionReindex()
    {
        $this->stdout('Clearing of index' . PHP_EOL);
        $this->productIndexer->clear();
        $this->stdout('Creating of index' . PHP_EOL);
        $this->productIndexer->createIndex();

        $products = $this->productRepository->findAll();

        foreach ($products as $product) {
            $this->stdout('Product #' . $product->id . PHP_EOL);
            $this->productIndexer->index($product);
        }
        $this->stdout('Done!' . PHP_EOL);
    }
}