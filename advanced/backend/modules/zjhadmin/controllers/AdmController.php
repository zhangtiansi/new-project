<?php
namespace app\modules\zjhadmin\controllers;
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
//                 'only'=>['index','error','create','update','view'],
                'denyCallback' => function ($rule, $action) {
                    $this->redirect(['site/error','message'=>'你无权访问该页面','type'=>'access']);
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup','error','wxdata'],
                        'roles' => ['?'],
                    ],
                    [
                    'allow' => true,
                    'actions' => ['addmoney','blacklist','unblacklist','resetavatar'],
                    'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [ 'index','create','sslconf','coin','banip','getdata','findout','gettopgift','topgift','send','mail','hischange','tbs','his','modssl4','sysconf','error','getsslper','getsslwin','view','update','datacenter','usersystem','recent','getserverid','getbet','getrecentdata','unreadlist','readlist','fetchunread','sendcust','mod'],
                        'matchCallback' => function ($rule, $action) {
                            Yii::error('user id :'.Yii::$app->user->id);
                            $user = User::findIdentity(Yii::$app->user->id);
                            if (is_object($user)){
                                //Yii::info('user: '.print_r($user->attributes,true));
                                return ($user->checkRole(User::ROLE_CUSTOMER)||$user->checkRole(User::ROLE_OPS)||$user->checkRole(User::ROLE_DATA)||$user->checkRole(User::ROLE_BUSS));
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