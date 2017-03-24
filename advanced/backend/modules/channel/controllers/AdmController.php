<?php
namespace app\modules\channel\controllers;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
class AdmController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(['site/error','message'=>'你无权访问该页面','type'=>'access']);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup','error'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [ 'index' ],
                        'matchCallback' => function ($rule, $action) {
                            $user = User::findIdentity(Yii::$app->user->id);
                            if (is_object($user)){
                                return ($user->checkRole(User::ROLE_CHANNEL_CPS)||$user->checkRole(User::ROLE_CHANNEL_CPA));
                            }else {
                                return false;
                            }
                        }
                    ],
                ],
            ],
        ];
    }
    
}