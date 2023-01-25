<?php

namespace app\controllers;

use app\components\common\AppController;
use app\components\helpers\AppHelper;
use app\components\helpers\DeviceDetectorHelper;
use app\components\helpers\SeoHelper;
use app\models\LoginForm;
use app\models\RecoveryForm;
use app\models\RegistrationForm;
use app\models\User;
use Yii;
use yii\web\Response;

/**
 * Class SiteController
 * @package app\controllers
 */
class SiteController extends AppController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    /**
     * Displays homepage.
     * @return string
     */
    public function actionIndex()
    {
        if (AppHelper::isGuest()) {
            SeoHelper::setTitle(Yii::$app->name);
            SeoHelper::setDescription('SAAS Service description');
            if (DeviceDetectorHelper::isMobile()) {
                $view = 'landing/mobile';
            } else {
                $view = 'landing/desktop';
            }
        } else {
            $view = 'index';
        }
        return $this->render($view);
    }


    /**
     * Login action.
     * @return Response|string
     */
    public function actionLogin()
    {
        $this->layout = 'blank';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $passwordReset = Yii::$app->request->get('password-reset');

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack('/');
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
            'passwordReset' => $passwordReset
        ]);
    }

    /**
     * Register action.
     * @return Response|string
     */
    public function actionRegister()
    {
        $this->layout = 'blank';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            $user = User::findByUsername($model->email);

            if ($user) {
                Yii::$app->user->login($user, 30 * 60);
            }
            return $this->redirect('/?new_user=1');
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    /**
     * Recovery action.
     * @return Response|string
     */
    public function actionRecovery()
    {
        $this->layout = 'blank';

        $success = Yii::$app->request->get('success');

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RecoveryForm();
        $model->setScenario(RecoveryForm::SCENARIO_REQUEST);
        if ($model->load(Yii::$app->request->post()) && $model->sendRecoveryMessage()) {
            return $this->redirect('/recovery/?success=1');
        }

        return $this->render('recovery', [
            'model' => $model,
            'success' => $success
        ]);
    }

    /**
     * Reset password action.
     * @return Response|string
     */
    public function actionResetPassword($hash)
    {
        $this->layout = 'blank';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $user = User::find()->andWhere(['recovery_token' => $hash])
            ->andWhere(['>=', 'recovery_sent_at', time() - 86400])
            ->one();

        $tokenFailure = false;


        if (!$user) {
            $tokenFailure = true;
        }

        $model = new RecoveryForm();
        $model->setScenario(RecoveryForm::SCENARIO_RESET);
        if ($model->load(Yii::$app->request->post()) && $model->resetPassword($user)) {
            return $this->redirect('/login/?password-reset=1');
        }

        return $this->render('reset-password', [
            'model' => $model,
            'tokenFailure' => $tokenFailure
        ]);
    }


    /**
     * Logout action.
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
