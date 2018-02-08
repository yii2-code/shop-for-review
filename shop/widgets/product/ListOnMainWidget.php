<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 08.02.18
 * Time: 16:20
 */

namespace shop\widgets\product;


use shop\entities\repositories\Product\ProductRepository;
use yii\jui\Widget;

class ListOnMainWidget extends Widget
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(
        array $config = [],
        ProductRepository $productRepository
    )
    {
        parent::__construct($config);
        $this->productRepository = $productRepository;
    }

    public function run()
    {
        $models = $this->productRepository->listOnMain();

        return $this->render('list-on-main', ['list' => array_chunk($models, 4)]);
    }
}