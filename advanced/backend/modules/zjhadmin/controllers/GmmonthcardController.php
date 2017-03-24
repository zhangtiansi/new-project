<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\GmMonthCard;
use app\models\GmMonthCardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;

/**
 * GmmonthcardController implements the CRUD actions for GmMonthCard model.
 */
class GmmonthcardController extends AdmController
{
  
    /**
     * Lists all GmMonthCard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GmMonthCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GmMonthCard model.
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
     * Creates a new GmMonthCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GmMonthCard();

        if ($model->load(Yii::$app->request->post())) {
            $gid = $model->gid;
            $producttype = GmMonthCard::PRODUCT_CARD_WEEK;
            Yii::error(print_r($model->attributes,true));
            if ($_POST['GmMonthCard']['card_type'] == 1)
            {
                $producttype = GmMonthCard::PRODUCT_CARD_MONTH;
            }
            $user = User::findIdentity(Yii::$app->user->id);
            if (is_object($user) &&( $user->checkRole(User::ROLE_ADMIN)))
            {
                $order="后台操作".$user->userdisplay."添加";
                if (GmMonthCard::AddCard($gid, $producttype, $order))
                    return $this->redirect(['index']);
                else 
                    return $this->redirect(['failed']);
            }else {
                return $this->redirect(['noaccess']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing GmMonthCard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->gid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GmMonthCard model.
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
     * Finds the GmMonthCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GmMonthCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GmMonthCard::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
