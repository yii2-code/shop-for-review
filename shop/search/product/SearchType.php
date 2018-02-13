<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 13.02.18
 * Time: 18:29
 */

namespace shop\search\product;


use shop\entities\Product\CategoryAssign;
use shop\entities\Product\Product;
use shop\entities\query\Product\ProductQuery;
use shop\entities\repositories\Product\CategoryRepository;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class SearchType
 * @package shop\search\product
 */
class SearchType extends Model
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var ProductQuery
     */
    protected $query;

    /**
     * SearchType constructor.
     * @param CategoryRepository $categoryRepository
     * @param array $config
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        array $config = []
    )
    {
        parent::__construct($config);
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return SearchType|object
     * @throws \yii\base\InvalidConfigException
     */
    public static function createType(): self
    {
        return \Yii::createObject(static::class);
    }

    /**
     * @var
     */
    public $keywords;
    /**
     * @var
     */
    public $brandId;
    /**
     * @var
     */
    public $categoryId;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['keywords'], 'string'],
            [['brandId', 'categoryId'], 'integer'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $this->query = Product::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $this->query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $this->filterByCategory();
        $this->query->andFilterWhere([Product::tableName() . '.[[brand_id]]' => $this->brandId]);
        $this->query->andFilterWhere(['LIKE', Product::tableName() . '.[[title]]', $this->keywords]);

        return $dataProvider;
    }

    /**
     *
     */
    public function filterByCategory()
    {
        if (is_numeric($this->categoryId)) {
            $category = $this->categoryRepository->findOne((int)$this->categoryId);
            $categoryIds = $category->getDescendants()->select(['id'])->column();
            $categoryIds = array_merge([$category->id], $categoryIds);
            $this->query->joinWith(['categoryAssigns']);
            $this->query->andWhere(
                ['OR',
                    [Product::tableName() . '.[[category_main_id]]' => $categoryIds],
                    [CategoryAssign::tableName() . '.[[category_id]]' => $categoryIds]
                ]
            );
        }
    }

    /**
     * @return string
     */
    public function formName()
    {
        return 'v';
    }
}