<?php

namespace app\controllers;

use app\models\LogTransactions;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\User;

class SiteController extends Controller {
    
    /**
     * @return array
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    
    /**
     * @return array
     */
    public function actions() {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    
    /**
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex() {
        $user       = Yii::$app->user;
        $loginCheck = false;
        
        if (!$user->isGuest) {
            $userName   = $user->identity->username;
            $model      = User::findByUsername($userName);
            $loginCheck = true;
            
            $modelLogTransact = new LogTransactions();
            $logTransations   = $modelLogTransact->getAllTransations();
        }
        
        return $this->render(
            'index',
            [
                'loginCheck'     => $loginCheck,
                'userName'       => $userName,
                'sumCurrent'     => $model->sum,
                'logTransations' => $logTransations,
            ]
        );
    }
    
    /**
     * @return Response
     */
    public function actionData() {
        $usernameId = htmlspecialchars($_POST['nameId']);;
        $sumTr = htmlspecialchars($_POST['sum']);
        $data  = htmlspecialchars($_POST['data']);
        
        $validate = $this->validator($usernameId, $sumTr, $data);
        if ($validate == true) {
            $dataToDb                  = date("Y-m-d H:i:s", strtotime($data));
            $logTransact               = new LogTransactions();
            $logTransact->data         = $dataToDb;
            $logTransact->from_user_id = Yii::$app->user->getId(); //от кого
            $logTransact->to_user_id   = $usernameId; //кому переводим
            $logTransact->sum          = $sumTr;
            $logTransact->save();
        }
        
        return $this->redirect(['site/index']);
    }
    
    /**
     * @param $usernameId
     * @param $sumTr
     * @param $data
     * @return bool
     */
    private function validator($usernameId, $sumTr, $data) {
        $userName       = Yii::$app->user->identity->username;
        $currentUser    = User::findByUsername($userName);
        $currentUserSum = $currentUser->sum;
        
        if (!intval($currentUserSum) || $currentUserSum <= 0 || ($currentUserSum - $sumTr < 0)) {
            echo "Недостаточно средств, сумма целочисленная";
            return false;
            
        }
        if (!intval($usernameId) || !(User::findOne($usernameId)) || (Yii::$app->user->getId() == $usernameId)) {
            echo "Пользователь не существует";
            return false;
        }
        if ($this->validateDate($data) == false) {
            echo "Некорректная дата";
            return false;
        }
        
        return true;
    }
    
    /**
     * @param $date
     * @param string $format
     * @return bool
     */
    private function validateDate($date, $format = 'd.m.Y H:i') {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    
    /**
     * @return string|Response
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        
        $model->password = '';
        return $this->render(
            'login',
            [
                'model' => $model,
            ]
        );
    }
    
    /**
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }
}
