<?php

namespace app\controllers;

use app\exceptions\UserNotFound;
use app\models\forms\MoneyTransferForm;
use app\models\User;
use app\services\BalanceService;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class UserController extends Controller
{
    private $service;
    private $request;
    private $session;
    private $currentUser;

    public function __construct($id, $module, $config = [], BalanceService $service)
    {
        parent::__construct($id, $module, $config);
        $this->service = $service;
        $this->request = Yii::$app->getRequest();
        $this->session = Yii::$app->getSession();
        $this->currentUser = Yii::$app->getUser();
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['transfer'],
                'rules' => [
                    [
                        'actions' => ['transfer'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'transfer' => ['get', 'post'],
                ],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->redirect('/');
    }

    /**
     * Transfer money to user.
     */
    public function actionTransfer()
    {
        $model = new MoneyTransferForm();
        if ($model->load($this->request->post()) && $model->validate()) {
            $sender = $this->findUser($this->currentUser->identity->username);
            $reciever = $this->findUser($model->username);

            $transfer = $this->service->transfer(
                $sender,
                $reciever,
                $model->amount
            );

            if ($transfer) {
                $this->session->setFlash('success', 'Transfer succeeded');
                return $this->goHome();
            } else {
                $this->session->setFlash('error', $this->service->getMessage());
            }

        }

        $user = User::findOne($this->request->get('userId'));

        $model->username = $user->username;
        return $this->render('transfer', compact('model'));
    }

    /**
     * @param $username
     *
     * @return User
     * @throws UserNotFound
     */
    private function findUser($username)
    {
        $user = User::findOne(compact('username'));

        if ($user !== null) {
            return $user;
        }

        throw new UserNotFound('User not found.');
    }
}
