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
use Exception;
use shop\entities\Auth\User;
use shop\entities\repositories\Auth\UserRepository;
use shop\helpers\UserHelper;
use shop\services\BaseService;
use shop\types\Auth\SignInType;
use shop\types\Auth\SignupType;
use Yii;
use yii\mail\MailerInterface;
use yii\web\NotFoundHttpException;

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
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function signup(SignupType $type): User
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!UserHelper::isEqual($type->password, $type->repeatPassword)) {
                throw new DomainException('Password must be equal to Repeat Password');
            }

            $user = User::requestSignup($type->password, $type->login, $type->email);
            $this->baseService->save($user);

            $this->send($user);
            $transaction->commit();
            return $user;
        } catch (Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }

    /**
     * @param string $password
     * @param string $login
     * @param string $email
     * @return User
     */
    public function createAdmin(
        string $password,
        string $login,
        string $email
    ): User
    {
        if (strlen($password) < 4 || strlen($password) > 100) {
            throw new DomainException(sprintf('The length of "%s" is too small or too big', $password));
        }

        if (strlen($login) < 4 || strlen($login) > 100) {
            throw new DomainException(sprintf('The length of "%s" is too small or too big', $login));
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) == false) {
            throw new DomainException(sprintf('The "%s" is invalid email address', $email));
        }

        $user = User::createAdmin(
            $password,
            $login,
            $email
        );
        $this->baseService->save($user);
        return $user;
    }

    /**
     * @param SignInType $type
     * @return User
     */
    public function signIn(SignInType $type): User
    {
        $user = $this->userRepository->findOneByLogin($type->login);
        $this->baseService->domainException($user, Yii::t('auth', 'Incorrectly login or password'));


        if (!$user->validatePassword($type->password)) {
            throw new DomainException('The Login and Password is not valid');
        }

        if ($user->isConfirmEmail()) {
            $this->send($user);
            throw new DomainException('You must active email');
        }

        if ($user->isDelete()) {
            throw new DomainException(Yii::t('auth', 'Your account is blocked'));
        }


        if (!$user->isActive()) {
            throw new DomainException(Yii::t('auth', 'Incorrectly login or password'));
        }

        return $user;
    }

    /**
     * @param string $token
     * @return User
     * @throws NotFoundHttpException
     */
    public function activeEmail(string $token): User
    {
        if (empty($token)) {
            throw new NotFoundHttpException(Yii::t('shop', 'The required page does not exist'));
        }

        $user = $this->userRepository->findOneByEmailActive($token);
        $this->baseService->notFoundHttpException($user);

        if (!$user->isConfirmEmail() && !$user->isActive()) {
            throw new NotFoundHttpException(Yii::t('shop', 'The required page does not exist'));
        }

        $user->setStatus($user::STATUS_ACTIVE);

        $this->baseService->save($user);

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
            Yii::warning('Unable to send message', 'shop');
        }
    }
}