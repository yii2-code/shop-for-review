<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 16:32
 */

namespace backend\controllers\auth;


use DomainException;
use RuntimeException;
use shop\services\Auth\UserService;
use shop\services\BaseService;
use shop\types\Auth\SignInType;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class UserController
 * @package frontend\controllers\auth
 */
class AuthController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var BaseService
     */
    private $baseService;

    /**
     * UserController constructor.
     * @param string $id
     * @param Module $module
     * @param UserService $userService
     * @param BaseService $baseService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        UserService $userService,
        BaseService $baseService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->userService = $userService;
        $this->baseService = $baseService;
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
}