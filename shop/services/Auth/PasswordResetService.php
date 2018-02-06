<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 14:34
 */

declare(strict_types=1);

namespace shop\services\Auth;

use DomainException;
use shop\entities\Auth\User;
use shop\entities\repositories\Auth\UserRepository;
use shop\helpers\UserHelper;
use shop\services\BaseService;
use shop\types\Auth\RequestPasswordResetType;
use shop\types\Auth\ResetPasswordType;
use Yii;
use yii\mail\MailerInterface;
use yii\web\NotFoundHttpException;

/**
 * Class PasswordResetService
 * @package shop\services\Auth
 */
class PasswordResetService
{
    /**
     * @var \shop\entities\repositories\Auth\UserRepository
     */
    public $userRepository;
    /**
     * @var BaseService
     */
    public $baseService;
    /**
     * @var MailerInterface
     */
    private $mailer;

    /**
     * UserService constructor.
     * @param BaseService $baseService
     * @param \shop\entities\repositories\Auth\UserRepository $userRepository
     * @param MailerInterface $mailer
     */
    public function __construct(
        BaseService $baseService,
        UserRepository $userRepository,
        MailerInterface $mailer
    )
    {
        $this->baseService = $baseService;
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    /**
     * @param RequestPasswordResetType $type
     * @return User
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function request(RequestPasswordResetType $type): User
    {
        $user = $this->userRepository->findOneByEmail($type->email);
        $this->baseService->notFoundHttpException($user);
        $user->generatePasswordReset();
        $this->baseService->save($user);
        $this->send($user);
        return $user;
    }

    /**
     * @param string $token
     * @param ResetPasswordType $type
     * @return User
     */
    public function reset(string $token, ResetPasswordType $type): User
    {
        if (!$this->validatePasswordReset($token, Yii::$app->params['user.passwordResetTokenExpire'])) {
            throw new DomainException('This token is invalid');
        }

        if (!UserHelper::isEqual($type->password, $type->repeatPassword)) {
            throw new DomainException('Password must be equal to Repeat Password');
        }

        $user = $this->userRepository->findOneByPasswordReset($token);
        $this->baseService->domainException($user, 'The required user does not exist');
        $user->setPassword($type->password);
        $user->removePasswordReset();
        $this->baseService->save($user);
        return $user;
    }

    /**
     * @param string $token
     * @param int $expire
     * @return bool
     */
    public function validatePasswordReset(string $token, int $expire): bool
    {
        if (empty($token)) {
            return false;
        }
        $timestamp = substr($token, strrpos($token, '_') + 1);
        if (!is_numeric($timestamp)) {
            return false;
        }
        return time() < $timestamp + $expire;
    }

    /**
     * @param User $user
     */
    public function send(User $user): void
    {
        $sent = $this->mailer
            ->compose('passwordResetToken', ['user' => $user])
            ->setSubject('Shop')
            ->setTo($user->email)
            ->send();

        if (!$sent) {
            Yii::warning('Unable to send message', 'shop');
        }
    }
}