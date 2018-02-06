<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 06.02.18
 * Time: 15:20
 */

declare(strict_types=1);

namespace shop\services\Auth;


use shop\entities\Auth\Profile;
use shop\entities\repositories\Auth\ProfileRepository;
use shop\services\BaseService;
use shop\types\Auth\ProfileType;

/**
 * Class ProfileService
 * @package shop\services\Auth
 */
class ProfileService
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var ProfileRepository
     */
    private $profileRepository;

    /**
     * ProfileService constructor.
     * @param BaseService $baseService
     * @param ProfileRepository $profileRepository
     */
    public function __construct(
        BaseService $baseService,
        ProfileRepository $profileRepository
    )
    {
        $this->baseService = $baseService;
        $this->profileRepository = $profileRepository;
    }

    /**
     * @param Profile $model
     * @return ProfileType
     */
    public function createType(Profile $model): ProfileType
    {
        return new ProfileType($model);
    }

    /**
     * @param int $id
     * @param ProfileType $type
     * @return Profile
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit(int $id, ProfileType $type): Profile
    {
        $profile = $this->profileRepository->findOne($id);
        $this->baseService->notFoundHttpException($profile);
        $profile->edit($type->firstName, $type->middleName, $type->lastName, $type->about);
        $profile->setSrc($type->src);
        $this->baseService->save($profile);
        return $profile;
    }
}