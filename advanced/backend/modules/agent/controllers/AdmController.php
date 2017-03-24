<?php
namespace app\modules\agent\controllers;
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
                        'actions' => [ 'index','create','view','send','recharge','gift','rec' ],
                        'matchCallback' => function ($rule, $action) {
                            $user = User::findIdentity(Yii::$app->user->id);
                            if (is_object($user)){
                                Yii::error("access callback is user object");
                                return $user->checkRole(User::ROLE_AGENT);
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