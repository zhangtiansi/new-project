<?php
// namespace backend\modules\zjhadmin\controllers;
namespace app\modules\zjhadmin\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use app\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\SignupForm;
use yii\filters\VerbFilter;
use app\models\User;

/**
 * Site controller
 */
class SiteController extends AdmController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        
    }
    
    public function actionError()
    {
        $this->layout="main_a";
        $message = Yii::$app->getRequest()->getQueryParam('message');
        $type=Yii::$app->getRequest()->getQueryParam('type');
        return $this->render('error',['message'=>$message,'type'=>$type]);
    }

    public function actionIndex()
    {
        $this->layout="main_a";
        return $this->render('index');
    }

    public function actionLogin()
    {
        $this->layout="main_a";
//         if (!\Yii::$app->user->isGuest) {
//             return $this->goHome();
//         }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = User::findIdentity(Yii::$app->user->id);
            if (is_object($user) && $user->checkRole(User::ROLE_ADMIN)){
                return $this->redirect(['default/recent']);
            }else {
                return $this->redirect(['logmsg/index']);
            }
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::error('logout ');
        Yii::$app->user->logout();

        return $this->redirect(['login']);
    }
    
    
//     public function actionSignup()
//     {
//         $model = new SignupForm();
//         if ($model->load(Yii::$app->request->post())) {
//             if ($user == $model->signup()) {
//                 if (Yii::$app->getUser()->login($user)) {
//                     return $this->goHome();
//                 }
//             }
//         }
    
//         return $this->render('signup', [
//             'model' => $model,
//         ]);
//     }
    
//     public function actionRequestPasswordReset()
//     {
//         $model = new PasswordResetRequestForm();
//         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//             if ($model->sendEmail()) {
//                 Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');
    
//                 return $this->goHome();
//             } else {
//                 Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
//             }
//         }
    
//         return $this->render('requestPasswordResetToken', [
//             'model' => $model,
//         ]);
//     }
    
//     public function actionResetPassword($token)
//     {
//         try {
//             $model = new ResetPasswordForm($token);
//         } catch (InvalidParamException $e) {
//             throw new BadRequestHttpException($e->getMessage());
//         }
    
//         if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
//             Yii::$app->getSession()->setFlash('success', 'New password was saved.');
    
//             return $this->goHome();
//         }
    
//         return $this->render('resetPassword', [
//             'model' => $model,
//         ]);
//     }
}
