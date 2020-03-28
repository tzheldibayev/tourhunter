<?php

namespace app\controllers;

use app\models\forms\MoneyTransferForm;
use app\models\User;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use Yii;

class UserController extends Controller
{
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

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->setFlash('success', 'Transfer succeeded');
            return $this->goHome();
        }

        $user = User::findOne(Yii::$app->getRequest()->get('userId'));
        $model->username = $user->username;

        return $this->render('transfer', compact('model'));
    }
}
