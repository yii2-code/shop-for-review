<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 22.01.18
 * Time: 17:58
 */

namespace shop\services\Auth;


use DomainException;
use Exception;
use shop\entities\Auth\Auth;
use shop\entities\Auth\User;
use shop\entities\repositories\Auth\AuthRepository;
use shop\entities\repositories\Auth\UserRepository;
use shop\services\BaseService;
use Yii;

/**
 * Class AuthService
 * @package shop\services\Auth
 */
class AuthService
{
    /**
     * @var BaseService
     */
    private $baseService;
    /**
     * @var AuthRepository
     */
    private $authRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * AuthService constructor.
     * @param BaseService $baseService
     * @param AuthRepository $authRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        BaseService $baseService,
        AuthRepository $authRepository,
        UserRepository $userRepository
    )
    {
        $this->baseService = $baseService;
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
    }


    /**
     * @param string $login
     * @param string $email
     * @param string $source
     * @param string $sourceId
     * @return User
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function request(string $login, string $email, string $source, string $sourceId): User
    {

        if (YII_ENV_TEST) {
            $transaction = Yii::$app->db->transaction;
        } else {
            $transaction = Yii::$app->db->beginTransaction();
        }

        try {
            $auth = $this->authRepository->findOneBy($source, $sourceId);
            if (is_null($auth)) {

                if (!is_null($this->userRepository->findOneByEmail($email))) {
                    throw new DomainException('User with the same email account already exists');
                }
                if (!is_null($this->userRepository->findOneByLogin($login))) {
                    throw new DomainException('User with the same login account already exists');
                }
                $user = User::requestSignup(
                    Yii::$app->security->generateRandomString(6),
                    $login,
                    $email,
                    User::STATUS_ACTIVE
                );
                $this->baseService->save($user);
                $auth = Auth::create(
                    $user->id,
                    $source,
                    $sourceId
                );
                $this->baseService->save($auth);

            } else {
                $auth = $this->authRepository->findOneBy($source, $sourceId);
                $user = $auth->user;
            }
            $this->baseService->notFoundHttpException($user);
            if (!$user->isActive()) {
                throw new DomainException(Yii::t('auth', 'Your account is blocked'));
            }
            $transaction->commit();
            return $user;
        } catch (Exception $exception) {
            $transaction->rollBack();
            throw $exception;
        }

    }
}