<?php

namespace app\modules\newzjhadmin\controllers;

use app\models\UserRole;
use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Permission;
use app\models\PermissionRole;
use app\models\Roles;
use yii\data\Pagination;


class RolesController extends AdmController
{
    public function actionIndex(){
        $query = Roles::find();
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
        $model = new Roles();
        $request = Yii::$app->request;
        $postRequest = $request->post();
        $model -> name = $postRequest['name'];
        $model -> display_name = $postRequest['display_name'];
        $model -> level = 10;
        $model -> created_at = date('Y-m-d H:i:s',time()+28800);
        $model -> updated_at = date('Y-m-d H:i:s',time()+28800);
        if($model->save()){
            foreach($postRequest['permission_id'] as $value){
                $permission_model = new PermissionRole();
                $permission_model->roles_id = $model->id;
                $permission_model->permission_id = $value;
                $permission_model->save();
            }
            return json_encode(array('status'=>'y','message'=>'添加成功'));
        }
            return false;
    }


    public function actionUpdate(){
        $request = Yii::$app->request;
        $postRequest = $request->post();
        $model = Roles::find()->filterWhere(['id'=>$postRequest['id']])->one();
        $model->name = $postRequest['name'];
        $model->display_name = $postRequest['display_name'];
        $model->updated_at = date('Y-m-d H:i:s',time()+28800);
        $permission_rolde_result = PermissionRole::find()->filterWhere(['roles_id'=>$postRequest['id']])->all();
        if($permission_rolde_result !=''){
            PermissionRole::deleteAll('roles_id=:roles_id',[':roles_id' => $postRequest['id']]);
        }
        if($model->save()){
            foreach($postRequest['permission_id'] as $value){
                $permission_role_model = new PermissionRole();
                $permission_role_model->roles_id = $postRequest['id'];
                $permission_role_model->permission_id = $value;
                $permission_role_model->save();
            }
            return json_encode(array('status'=>'y','message'=>'修改成功'));
        }
            return false;
    }

    public function actionRolesdelete(){
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $roles_result = Roles::find()->filterWhere(['id'=>$getRequest['id']])->one();
        if($roles_result !=''){
            $roles_delete_result = $roles_result->delete();
        }
        $permission_roles_result = PermissionRole::find()->filterWhere(['roles_id'=>$getRequest['id']])->all();
        if($permission_roles_result !=''){
            $permission_role_delete_result = PermissionRole::deleteAll('roles_id=:roles_id',[':roles_id' => $getRequest['id']]);
        }
        $user_roles_result = UserRole::find()->filterWhere(['roles_id'=>$getRequest['id']])->all();
        if($user_roles_result !=''){
            $user_roles_delete_result = UserRole::deleteAll('roles_id=:roles_id',[':roles_id' => $getRequest['id']]);
        }
        if((isset($roles_delete_result) && $roles_delete_result == true) || (isset($permission_role_delete_result) && $permission_role_delete_result == true) || (isset($user_roles_delete_result) && $user_roles_delete_result == true)){
            return json_encode(array('status'=>'y','message'=>'删除成功'));
        }
        return false;
    }

    public function actionView(){
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $role_name = Roles::find()->filterWhere(['id'=>$getRequest['id']])->one();
        $result = PermissionRole::find()->filterWhere(['roles_id'=>$getRequest['id']])->all();
        $permission_id_list = '';
        foreach($result as $key=>$value){
            $permission_id_list[] = $value->permission_id;
        }
        $permission_list = Permission::find()->filterWhere(['in','id',$permission_id_list])->all();
        return $this->render('view',['list'=>$permission_list,'name'=>$role_name['display_name']]);
    }
}