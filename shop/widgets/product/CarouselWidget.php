<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 07.02.18
 * Time: 19:08
 */

namespace shop\widgets\product;


use shop\entities\repositories\Product\ProductRepository;
use yii\base\Widget;

/**
 * Class CarouselWidget
 * @package shop\widgets\product
 */
class CarouselWidget extends Widget
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * CarouselWidget constructor.
     * @param ProductRepository $productRepository
     * @param array $config
     */
    public function __construct(
        ProductRepository $productRepository,
        array $config = []
    )
    {
        parent::__construct($config);
        $this->productRepository = $productRepository;
    }

    /**
     * @return string
     */
    public function run()
    {
        $models = $this->productRepository->carousel();

        return $this->render('carousel', ['models' => $models]);
    }
}