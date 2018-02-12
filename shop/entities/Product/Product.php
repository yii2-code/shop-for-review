<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 25.01.18
 * Time: 18:39
 */

declare(strict_types=1);

namespace shop\entities\Product;

use app\behaviors\TagDependencyBehavior;
use app\behaviors\TimestampBehavior;
use app\modules\image\models\Image;
use app\modules\image\services\ImageManager;
use app\modules\image\services\ImageManagerInterface;
use app\modules\tag\models\Tag;
use app\modules\tag\models\TagAssign;
use app\modules\tag\services\TagAssignService;
use DomainException;
use shop\entities\query\Product\ProductQuery;
use shop\entities\repositories\Product\BrandRepository;
use shop\entities\repositories\Product\CategoryRepository;
use shop\helpers\ProductHelper;
use shop\services\Product\CategoryAssignService;
use shop\services\Product\ValueService;
use shop\types\Product\ValueType;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

/**
 * Class Product
 * @package shop\entities\Product
 * @property $id int
 * @property $status int
 * @property $price int
 * @property $old_price int
 * @property $brand_id int
 * @property $category_main_id int
 * @property $title string
 * @property $announce string
 * @property $description string
 * @property $created_at string
 * @property $updated_at string
 *
 * @property Brand $brand
 * @property Category $categoryMain
 * @property Tag[] $tags
 * @property Value[] $values
 * @property Category[] $categories
 * @property CategoryAssign[] $categoryAssigns
 * @property Image[] $images
 * @property Image $mainImage
 */
class Product extends ActiveRecord
{
    /**
     *
     */
    const STATUS_ACTIVE = 1;
    /**
     *
     */
    const STATUS_DELETE = 2;

    /**
     * @return string
     */
    public static function tableName()
    {
        return '{{%product}}';
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'TimestampBehavior' => TimestampBehavior::class,
            'TagDependencyBehavior' => TagDependencyBehavior::class,
        ];
    }

    /**
     * @return ProductQuery
     */
    public static function find(): ProductQuery
    {
        return new ProductQuery(static::class);
    }

    /**
     * @param string $title
     * @param string $announce
     * @param string $description
     * @param int $status
     * @param int $price
     * @param int $brandId
     * @param int $categoryMainId
     * @param int|null $oldPrice
     * @return Product
     * @throws \yii\base\InvalidConfigException
     */
    public static function create(
        string $title,
        string $announce,
        string $description,
        int $status,
        int $price,
        int $brandId,
        int $categoryMainId,
        int $oldPrice = null
    ): self
    {
        $model = new static();
        $model->title = $title;
        $model->announce = $announce;
        $model->description = $description;
        $model->status = $status;
        $model->editPrice($price, $oldPrice);
        $model->setBrandId($brandId);
        $model->setCategoryMainId($categoryMainId);
        return $model;
    }

    /**
     * @param string $title
     * @param string $announce
     * @param string $description
     * @param int $status
     * @param int $brandId
     * @param int $categoryMainId
     * @throws \yii\base\InvalidConfigException
     */
    public function edit(
        string $title,
        string $announce,
        string $description,
        int $status,
        int $brandId,
        int $categoryMainId
    ): void
    {
        $this->title = $title;
        $this->announce = $announce;
        $this->description = $description;
        $this->status = $status;
        $this->setBrandId($brandId);
        $this->setCategoryMainId($categoryMainId);
    }

    /**
     * @param int $price
     * @param int|null $oldPrice
     */
    public function editPrice(int $price, int $oldPrice = null): void
    {
        $this->price = $price;
        if ($oldPrice == 0) {
            $this->old_price = null;
        } else {
            $this->old_price = $oldPrice;
        }
    }

    /**
     * @param int $id
     * @throws \yii\base\InvalidConfigException
     */
    public function setBrandId(int $id): void
    {
        /** @var BrandRepository $repository */
        $repository = Instance::ensure(BrandRepository::class);
        if (!$repository->existsById($id)) {
            throw new DomainException('Incorrectly brand');
        }
        $this->brand_id = $id;
    }

    /**
     * @param int $id
     * @throws \yii\base\InvalidConfigException
     */
    public function setCategoryMainId(int $id): void
    {
        /** @var CategoryRepository $categoryRepository */
        $categoryRepository = Instance::ensure(CategoryRepository::class);

        if (!$categoryRepository->existsById($id)) {
            throw new DomainException('Incorrectly category');
        }
        $this->category_main_id = $id;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryMain()
    {
        return $this->hasOne(Category::class, ['id' => 'category_main_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
            ->via('categoryAssigns');
    }

    /**
     * @return ActiveQuery
     */
    public function getCategoryAssigns()
    {
        return $this->hasMany(CategoryAssign::class, ['product_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::class, ['id' => 'tag_id'])
            ->via('tagAssigns');
    }

    /**
     * @return ActiveQuery
     */
    public function getTagAssigns()
    {
        return $this->hasMany(TagAssign::class, ['record_id' => 'id'])
            ->andWhere(['class' => static::class]);
    }

    /**
     * @return ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ['record_id' => 'id'])->andWhere(['class' => static::class]);
    }

    /**
     * @return ActiveQuery
     */
    public function getMainImage()
    {
        return $this->hasOne(Image::class, ['record_id' => 'id'])->andWhere(['class' => static::class, 'main' => Image::MAIN]);
    }

    /**
     * @return \app\modules\image\TDO\ImageTdo[]|array
     * @throws \yii\base\InvalidConfigException
     */
    public function getImagesDto()
    {
        /** @var ImageManager $manager */
        $manager = \Yii::createObject(ImageManagerInterface::class);
        return $manager->wrap($this->images);
    }


    /**
     * @return \app\modules\image\TDO\ImageTdo
     * @throws \yii\base\InvalidConfigException
     */
    public function getMainImageDto()
    {
        /** @var ImageManager $manager */
        $manager = \Yii::createObject(ImageManagerInterface::class);
        return $manager->createImageTdo($this->mainImage);
    }

    /**
     * @return ActiveQuery
     */
    public function getValues()
    {
        return $this->hasMany(Value::class, ['product_id' => 'id'])->orderBy(['id' => SORT_ASC]);
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return ArrayHelper::getValue(ProductHelper::getStatusDropDown(), $this->status);
    }


    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function attachImages(): void
    {
        /** @var ImageManager $manager */
        $manager = Instance::ensure(ImageManagerInterface::class, ImageManagerInterface::class);
        $manager->createService()->editAfterCreatedRecord($this->id, static::className());
    }

    /**
     * @param array $tags
     * @throws \yii\base\InvalidConfigException
     */
    public function attachTags(array $tags): void
    {
        /** @var TagAssignService $service */
        $service = Instance::ensure(TagAssignService::class);
        $service->assign(static::class, $this->id, $tags);
    }

    /**
     * @param ValueType $type
     * @throws \yii\base\InvalidConfigException
     */
    public function attachValue(ValueType $type): void
    {
        /** @var ValueService $service */
        $service = Instance::ensure(ValueService::class);
        $service->create($this->id, $type);
    }

    /**
     * @param int $id
     * @throws \yii\base\InvalidConfigException
     */
    public function attachCategory(int $id): void
    {
        /** @var CategoryAssignService $service */
        $service = Instance::ensure(CategoryAssignService::class);
        $service->create($this->id, $id);
    }
}