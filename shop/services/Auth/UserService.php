<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 18.01.18
 * Time: 20:50
 */

declare(strict_types=1);

namespace shop\services\Auth;

use DomainException;
use shop\entities\Auth\User;
use shop\entities\repositories\UserRepository;
use shop\services\BaseService;
use shop\types\Auth\SignInType;
use shop\types\Auth\SignupType;
use Yii;
use yii\mail\MailerInterface;

/**
 * Class UserService
 * @package shop\services\Auth
 */
class UserService
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var MailerInterface
     */
    private $mailer;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param BaseService $baseService
     * @param MailerInterface $mailer
     * @param UserRepository $userRepository
     */
    public function __construct(
        BaseService $baseService,
        MailerInterface $mailer,
        UserRepository $userRepository
    )
    {
        $this->baseService = $baseService;
        $this->mailer = $mailer;
        $this->userRepository = $userRepository;
    }

    /**
     * @param SignupType $type
     * @return User
     * @throws \yii\base\Exception
     */
    public function signup(SignupType $type): User
    {
        if (!$this->isEqual($type->password, $type->repeatPassword)) {
            throw new DomainException('Password must be equal to Repeat Password');
        }

        $user = User::requestSignup($type->password, $type->login, $type->email);
        $this->baseService->save($user);

        $this->send($user);

        return $user;
    }

    /**
     * @param SignInType $type
     * @return User
     */
    public function signIn(SignInType $type): User
    {
        $user = $this->userRepository->findOneByLogin($type->login);
        $this->baseService->domainException($user, 'The Login and Password is not valid');


        if (!$user->validatePassword($type->password)) {
            throw new DomainException('The Login and Password is not valid');
        }

        if ($user->isConfirmEmail()) {
            $this->send($user);
            throw new DomainException('You must active email');
        }

        if ($user->isDelete()) {
            throw new DomainException('You is blocked');
        }


        if (!$user->isActive()) {
            throw new DomainException('The Login and Password is not valid');
        }

        return $user;
    }

    /**
     * @param User $user
     */
    public function send(User $user): void
    {
        $sent = $this->mailer
            ->compose('requestEmailToken', ['user' => $user])
            ->setSubject('Shop')
            ->setTo($user->email)
            ->send();

        if (!$sent) {
            Yii::warning('Sending error', 'shop');
        }
    }

    /**
     * @param string $password
     * @param string $repeatPassword
     * @return bool
     */
    public function isEqual(string $password, string $repeatPassword): bool
    {
        return $password == $repeatPassword;
    }
}