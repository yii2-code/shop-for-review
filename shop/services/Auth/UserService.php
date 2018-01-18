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
use shop\services\BaseService;
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
     * UserService constructor.
     * @param BaseService $baseService
     * @param MailerInterface $mailer
     */
    public function __construct(
        BaseService $baseService,
        MailerInterface $mailer
    )
    {
        $this->baseService = $baseService;
        $this->mailer = $mailer;
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

        $sent = $this->mailer
            ->compose('requestEmailToken', ['user' => $user])
            ->setSubject('Shop')
            ->setTo($user->email)
            ->send();

        if (!$sent) {
            Yii::warning('Sending error', 'shop');
        }

        return $user;
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