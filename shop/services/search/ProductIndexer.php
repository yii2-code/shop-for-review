<?php
/**
 * Created by PhpStorm.
 * User: cherem
 * Date: 20.02.18
 * Time: 18:39
 */

declare(strict_types=1);

namespace shop\services\search;


use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use shop\entities\Product\Product;
use shop\entities\repositories\Product\ProductRepository;
use yii\helpers\Console;

/**
 * Class ProductIndexer
 * @package shop\services\search
 */
class ProductIndexer
{
    /**
     *
     */
    const INDEX = 'shop';

    /**
     *
     */
    const TYPE = 'products';

    /**
     * @var Client
     */
    private $client;
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * ProductIndexer constructor.
     * @param Client $client
     * @param ProductRepository $productRepository
     */
    public function __construct(
        Client $client,
        ProductRepository $productRepository
    )
    {

        $this->client = $client;
        $this->productRepository = $productRepository;
    }

    /**
     *
     */
    public function clear(): void
    {
        try {
            $this->client->indices()->delete([
                'index' => static::INDEX
            ]);
        } catch (Missing404Exception $exception) {
            Console::stdout('Index is empty' . PHP_EOL);
        }
    }

    public function createIndex(): void
    {
        $this->client->indices()->create([
            'index' => static::INDEX,
            'body' => [
                'mappings' => [
                    'products' => [
                        '_source' => [
                            'enabled' => true,
                        ],
                        'properties' => [
                            'id' => [
                                'type' => 'integer',
                            ],
                            'title' => [
                                'type' => 'text',
                            ],
                            'announce' => [
                                'type' => 'text',
                            ],
                            'description' => [
                                'type' => 'text',
                            ],
                        ]
                    ]
                ]
            ]
        ]);
    }

    public function index(Product $product): void
    {
        $this->client->index([
            'index' => 'shop',
            'type' => 'products',
            'id' => $product->id,
            'body' => [
                'id' => $product->id,
                'title' => $product->title,
                'announce' => $product->announce,
                'description' => strip_tags($product->description),
            ],
        ]);
    }
}