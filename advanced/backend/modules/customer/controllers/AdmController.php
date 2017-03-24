<?php
namespace app\modules\customer\controllers;
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
                'only' => [],
                'denyCallback' => function ($rule, $action) {
                    throw new \Exception('您无权访问该页面');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['login', 'signup'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => [ 'index','create','view','update','recent' ],
                        'matchCallback' => function ($rule, $action) {
                            $user = User::findIdentity(Yii::$app->user->id);
                            if (is_object($user)){
                                Yii::error("access callback is user object");
                                return $user->checkRole(User::ROLE_CUSTOMER);
                            }else {
                                Yii::error("access callback is not user object");
                                return false;
                            }
                        }
                    ],
                ],
            ],
        ];
    }
    
}