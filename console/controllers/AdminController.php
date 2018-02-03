<?php
/**
 * Created by PhpStorm.
 * User: cheremhovo
 * Date: 03.02.18
 * Time: 20:27
 */

namespace console\controllers;


use DomainException;
use RuntimeException;
use shop\services\Auth\UserService;
use yii\base\Module;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class AdminController
 * @package console\controllers
 */
class AdminController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * AdminController constructor.
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
     * @param string $login
     * @param string $email
     * @param string $password
     * @return int
     */
    public function actionNew(string $login, string $email, string $password)
    {

        try {
            $this->userService->createAdmin($password, $login, $email);
            return ExitCode::OK;
        } catch (DomainException $exception) {
            $this->stdout($exception->getMessage() . PHP_EOL);
        } catch (RuntimeException $exception) {
            $this->stdout($exception->getMessage() . PHP_EOL);
        }
        return ExitCode::UNSPECIFIED_ERROR;
    }
}