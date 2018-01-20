<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 16:32
 */

namespace frontend\controllers\auth;


use DomainException;
use RuntimeException;
use shop\entities\Auth\User;
use shop\services\Auth\UserService;
use shop\types\Auth\SignInType;
use shop\types\Auth\SignupType;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class UserController
 * @package frontend\controllers\auth
 */
class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     * @param string $id
     * @param Module $module
     * @param UserService $userService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        UserService $userService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
    }


    /**
     * @return string
     */
    public function actionSignIn()
    {
        $type = new SignInType();

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->userService->signIn($type);
                $this->login($model);
                return $this->goHome();
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('warning', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('warning', 'Runtime error');
            }

        }
        return $this->render('sign-in', ['type' => $type]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSignOut()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function actionSignup()
    {
        $type = new SignupType();

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $this->userService->signup($type);
                Yii::$app->session->addFlash('info', 'You is success signup. The message is sent to you for active profile account');
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('warning', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('warning', 'Runtime error');
            }
        }

        return $this->render('signup', ['type' => $type]);
    }


    /**
     * @param $token
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionActiveEmail($token)
    {
        $model = $this->userService->activeEmail($token);
        $this->login($model);
        return $this->goHome();
    }

    /**
     * @param User $model
     */
    public function login(User $model): void
    {
        if (!Yii::$app->user->login($model)) {
            throw new RuntimeException('Login error');
        }
    }
}