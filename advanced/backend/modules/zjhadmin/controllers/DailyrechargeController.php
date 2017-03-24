<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\DataDailyRecharge;
use app\models\DataDailyRechargeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;

/**
 * DailyrechargeController implements the CRUD actions for DataDailyRecharge model.
 */
class DailyrechargeController extends Controller
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
                        'actions' => [ 'index',],
                        'matchCallback' => function ($rule, $action) {
                            Yii::error('user id :'.Yii::$app->user->id);
                            $user = User::findIdentity(Yii::$app->user->id);
                            if (is_object($user)){
                                //Yii::info('user: '.print_r($user->attributes,true));
                                return ($user->checkRole(User::ROLE_ADMIN)||$user->checkRole(User::ROLE_DATA)||$user->checkRole(User::ROLE_BUSS));
                            }else {
                                return false;
                            }
                        }
                    ],
                ],
            ],
            ];
    }

    /**
     * Lists all DataDailyRecharge models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataDailyRechargeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

//     /**
//      * Displays a single DataDailyRecharge model.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionView($id)
//     {
//         return $this->render('view', [
//             'model' => $this->findModel($id),
//         ]);
//     }

//     /**
//      * Creates a new DataDailyRecharge model.
//      * If creation is successful, the browser will be redirected to the 'view' page.
//      * @return mixed
//      */
//     public function actionCreate()
//     {
//         $model = new DataDailyRecharge();

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('create', [
//                 'model' => $model,
//             ]);
//         }
//     }

//     /**
//      * Updates an existing DataDailyRecharge model.
//      * If update is successful, the browser will be redirected to the 'view' page.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionUpdate($id)
//     {
//         $model = $this->findModel($id);

//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
//             return $this->render('update', [
//                 'model' => $model,
//             ]);
//         }
//     }

//     /**
//      * Deletes an existing DataDailyRecharge model.
//      * If deletion is successful, the browser will be redirected to the 'index' page.
//      * @param integer $id
//      * @return mixed
//      */
//     public function actionDelete($id)
//     {
//         $this->findModel($id)->delete();

//         return $this->redirect(['index']);
//     }

//     /**
//      * Finds the DataDailyRecharge model based on its primary key value.
//      * If the model is not found, a 404 HTTP exception will be thrown.
//      * @param integer $id
//      * @return DataDailyRecharge the loaded model
//      * @throws NotFoundHttpException if the model cannot be found
//      */
//     protected function findModel($id)
//     {
//         if (($model = DataDailyRecharge::findOne($id)) !== null) {
//             return $model;
//         } else {
//             throw new NotFoundHttpException('The requested page does not exist.');
//         }
//     }
}
