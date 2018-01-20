<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 14:34
 */

declare(strict_types=1);

namespace shop\services\Auth;

use shop\entities\Auth\User;
use shop\entities\repositories\UserRepository;
use shop\services\BaseService;
use shop\types\Auth\RequestPasswordResetType;
use shop\types\Auth\ResetPasswordType;
use yii\web\NotFoundHttpException;

/**
 * Class PasswordResetService
 * @package shop\services\Auth
 */
class PasswordResetService
{
    /**
     * @var UserRepository
     */
    public $userRepository;
    /**
     * @var BaseService
     */
    public $baseService;

    /**
     * UserService constructor.
     * @param BaseService $baseService
     * @param UserRepository $userRepository
     */
    public function __construct(
        BaseService $baseService,
        UserRepository $userRepository
    )
    {
        $this->baseService = $baseService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param RequestPasswordResetType $type
     * @return User
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function requestPasswordReset(RequestPasswordResetType $type): User
    {
        $user = $this->userRepository->findOneByEmail($type->email);
        $this->baseService->notFoundHttpException($user);
        $user->generatePasswordResetToken();
        $this->baseService->save($user);
        return $user;
    }

    /**
     * @param string $token
     * @param ResetPasswordType $type
     * @return User
     */
    public function resetPassword(string $token, ResetPasswordType $type): User
    {
        $user = $this->userRepository->findOneByPasswordReset($token);
        $this->baseService->domainException($user, 'The required user does not exist');
        $user->setPassword($type->password);
        $user->removePasswordResetToken();
        $this->baseService->save($user);
        return $user;
    }
}