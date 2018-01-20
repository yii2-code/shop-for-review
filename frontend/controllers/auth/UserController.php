<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 16:32
 */

namespace frontend\controllers\auth;


use DomainException;
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

        return $this->render('sign-in', ['type' => $type]);
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
            } catch (\RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('warning', 'Runtime error');
            }
        }

        return $this->render('signup', ['type' => $type]);
    }
}