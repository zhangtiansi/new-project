<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\DataMonthRecharge;
use app\models\DataMonthRechargeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use yii\filters\AccessControl;

/**
 * DatamonthrechargeController implements the CRUD actions for DataMonthRecharge model.
 */
class DatamonthrechargeController extends Controller
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
                        'actions' => [ 'index'],
                        'matchCallback' => function ($rule, $action) {
                            Yii::error('user id :'.Yii::$app->user->id);
                            $user = User::findIdentity(Yii::$app->user->id);
                            if (is_object($user)){
                                //Yii::info('user: '.print_r($user->attributes,true));
                                return $user->checkRole(User::ROLE_ADMIN);
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
     * Lists all DataMonthRecharge models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataMonthRechargeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DataMonthRecharge model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DataMonthRecharge model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DataMonthRecharge();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DataMonthRecharge model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DataMonthRecharge model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DataMonthRecharge model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataMonthRecharge the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataMonthRecharge::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
