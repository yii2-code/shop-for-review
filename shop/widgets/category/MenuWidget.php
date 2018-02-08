<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 04.02.18
 * Time: 16:36
 */

namespace shop\widgets\category;


use shop\entities\Product\Category;
use shop\entities\repositories\Product\CategoryRepository;
use yii\base\Widget;

/**
 * Class MenuWidget
 * @package shop\widgets\category
 */
class MenuWidget extends Widget
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * MenuWidget constructor.
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
     * @return string
     */
    public function run()
    {
        $root = $this->categoryRepository->findOneRoot();

        $root->populateTree();
        $menu = $this->buildMenu($root);

        return $this->render('menu', ['menu' => $menu]);
    }


    /**
     * @param Category $root
     * @return array
     */
    public function buildMenu(Category $root): array
    {
        $menu = [];
        foreach ($root->children as $level) {
            $menu[] = [
                'label' => $level->title,
                'url' => ['/product/category/index', 'id' => $level->id],
                'items' => $this->buildMenu($level)];
        }
        return $menu;
    }
}