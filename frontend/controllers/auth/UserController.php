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
use shop\services\Auth\AuthService;
use shop\services\Auth\UserService;
use shop\services\BaseService;
use shop\types\Auth\SignInType;
use shop\types\Auth\SignupType;
use Yii;
use yii\authclient\AuthAction;
use yii\authclient\ClientInterface;
use yii\base\Module;
use yii\helpers\ArrayHelper;
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
     * @var AuthService
     */
    private $authService;
    /**
     * @var BaseService
     */
    private $baseService;

    /**
     * UserController constructor.
     * @param string $id
     * @param Module $module
     * @param UserService $userService
     * @param AuthService $authService
     * @param BaseService $baseService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        UserService $userService,
        AuthService $authService,
        BaseService $baseService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
        $this->authService = $authService;
        $this->baseService = $baseService;
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'oauth' => [
                'class' => AuthAction::class,
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * @param ClientInterface $client
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function onAuthSuccess(ClientInterface $client)
    {
        $attributes = $client->getUserAttributes();
        $email = ArrayHelper::getValue($attributes, 'email');
        $sourceId = ArrayHelper::getValue($attributes, 'id');
        $login = ArrayHelper::getValue($attributes, 'login');
        $source = $client->getId();
        try {
            $model = $this->authService->request($login, $email, $source, $sourceId);
            $this->baseService->login($model);
            Yii::$app->session->addFlash('info', sprintf('To link your account <b>%s</b> to social network', $client->getTitle()));
        } catch (DomainException $exception) {
            Yii::$app->session->addFlash('warning', $exception->getMessage());
        } catch (RuntimeException $exception) {
            Yii::$app->errorHandler->logException($exception);
            Yii::$app->session->addFlash('warning', 'Runtime error');
        }
    }

    /**
     * @return string
     */
    public function actionSignIn()
    {
        $this->layout = 'sing-in';

        $type = new SignInType();

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->userService->signIn($type);
                $this->baseService->login($model);
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
        $this->baseService->login($model);
        return $this->goHome();
    }
}