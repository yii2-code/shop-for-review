<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 20.01.18
 * Time: 19:18
 */

namespace frontend\controllers\auth;


use DomainException;
use RuntimeException;
use shop\services\Auth\PasswordResetService;
use shop\types\Auth\RequestPasswordResetType;
use shop\types\Auth\ResetPasswordType;
use Yii;
use yii\base\Module;
use yii\web\Controller;

/**
 * Class PasswordResetController
 * @package frontend\controllers\auth
 */
class PasswordResetController extends Controller
{
    /**
     * @var PasswordResetService
     */
    private $passwordResetService;

    /**
     * PasswordResetController constructor.
     * @param string $id
     * @param Module $module
     * @param PasswordResetService $passwordResetService
     * @param array $config
     */
    public function __construct(
        string $id,
        Module $module,
        PasswordResetService $passwordResetService,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->passwordResetService = $passwordResetService;
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionRequest()
    {
        $type = new RequestPasswordResetType();

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $this->passwordResetService->request($type);
                Yii::$app->session->addFlash('info', 'The message is sent for reset password');
                return $this->goHome();
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('warning', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('warning', 'Runtime error');
            }
        }

        return $this->render('request', ['type' => $type]);
    }

    /**
     * @param $token
     * @return string|\yii\web\Response
     */
    public function actionReset($token)
    {
        $type = new ResetPasswordType();

        if ($type->load(Yii::$app->request->post()) && $type->validate()) {
            try {
                $model = $this->passwordResetService->reset($token, $type);
                if (!Yii::$app->user->login($model)) {
                    throw new RuntimeException('Login error');
                }
                return $this->goHome();
            } catch (DomainException $exception) {
                Yii::$app->session->addFlash('warning', $exception->getMessage());
            } catch (RuntimeException $exception) {
                Yii::$app->errorHandler->logException($exception);
                Yii::$app->session->addFlash('warning', 'Runtime error');
            }
        }

        return $this->render('reset', ['type' => $type]);
    }
}