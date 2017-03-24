<?php

namespace app\modules\newzjhadmin\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Permission;
use yii\data\Pagination;


class PermissionController extends AdmController
{
    public function actionIndex(){
        $query = Permission::find();
        $request = Yii::$app->request;
        $getRequest = $request->get();
        if(isset($getRequest['display_name']) && $getRequest['display_name'] != ''){
            $query = $query->filterWhere(['like', 'display_name', $getRequest['display_name']]);
        }
        $query->orderBy(['id' => SORT_DESC]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $result = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',['list'=>$result,'count'=>$count,'pagination'=>$pagination,'display_name'=>isset($getRequest['display_name']) ? $getRequest['display_name'] : '']);
    }

    public function actionCreate(){
        $model = new Permission();
        $request = Yii::$app->request;
        $postRequest = $request->post();
        $model -> name = $postRequest['name'];
        $model -> display_name = $postRequest['display_name'];
        $model -> description = $postRequest['description'];
        $model -> route = $postRequest['route'];
        $model -> created_at = date('Y-m-d H:i:s',time()+28800);
        $model -> updated_at = date('Y-m-d H:i:s',time()+28800);
        if($model->save()){
            return json_encode(array('status'=>'y','message'=>'添加成功'));
        }
            return false;
    }

    public function actionDeletepermission(){
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $permission_result = Permission::findOne($getRequest['id']);
        if($permission_result->delete()){
            return json_encode(array('status'=>'y','message'=>'删除成功'));
        }
            return false;
    }

    public function actionUpdate(){
        $request = Yii::$app->request;
        $postRequest = $request->post();
        $model = Permission::find()->filterWhere(['id'=>$postRequest['id']])->one();
        $model->name = $postRequest['name'];
        $model->display_name = $postRequest['display_name'];
        $model->description = $postRequest['description'];
        $model->route = $postRequest['route'];
        $model->updated_at = date('Y-m-d H:i:s',time()+28800);
        if($model->save()){
            return json_encode(array('status'=>'y','message'=>'修改成功'));
        }
            return false;
    }
}