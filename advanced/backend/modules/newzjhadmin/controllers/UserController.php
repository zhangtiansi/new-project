<?php

namespace app\modules\newzjhadmin\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\Permission;
use yii\data\Pagination;
//use app\models\PermissionUser;
use app\models\Roles;
use app\models\UserRole;

class UserController extends AdmController
{
    public function actionIndex(){
        $query = User::find();
        $request = Yii::$app->request;
        $getRequest = $request->get();
        if(isset($getRequest['username']) && $getRequest['username'] != ''){
            $query = $query->filterWhere(['like', 'username', $getRequest['username']]);
        }
        $query->orderBy(['id' => SORT_DESC]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $result = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        return $this->render('index',['list'=>$result,'count'=>$count,'pagination'=>$pagination,'username'=>isset($getRequest['username']) ? $getRequest['username'] : '']);
    }

    public function actionCreate(){
        $user_model = new User();
        $request = Yii::$app->request;
        $postRequest = $request->post();
        $user_model -> username = $postRequest['username'];
        $user_model -> userdisplay = $postRequest['userdisplay'];
        $user_model -> password_hash = $postRequest['password1'];
        $user_model -> email = $postRequest['email'];
        $user_model->role = 1;
        $user_model->created_at = time();
        $user_model->updated_at = time();
        if($user_model->save()){
            if($postRequest['role_id'] !=''){
                foreach($postRequest['role_id'] as $value){
                    $user_role_model = new UserRole();
                    $user_role_model->uid = $user_model->id;
                    $user_role_model->roles_id = $value;
                    $user_role_model->save();
                }
            }
            return json_encode(array('status'=>'y','message'=>'添加成功'));
        }
            return false;
    }

    public function actionUserdelete(){
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $user_result = User::findOne($getRequest['id']);
        if(isset($user_result) && $user_result !=''){
            $user_delete_result = $user_result->delete();
        }
        $user_role_result = UserRole::find()->filterWhere(['uid'=>$getRequest['id']])->one();
        if(isset($user_role_result) && $user_role_result!=''){
            $user_role_delete_result = UserRole::deleteAll('uid=:uid',[':uid'=>$getRequest['id']]);
        }
        if((isset($user_delete_result) && $user_delete_result == true) && (isset($user_role_delete_result) && $user_role_delete_result == true)){
            return json_encode(array('status'=>'y','message'=>'删除成功'));
        }
            return false;
    }

    public function actionUpdate(){
        $request = Yii::$app->request;
        $postRequest = $request->post();
        $user_roles_result = UserRole::find()->filterWhere(['uid'=>$postRequest['id']])->all();
        if($user_roles_result !=''){
            UserRole::deleteAll('uid=:uid',[':uid' => $postRequest['id']]);
        }
        $model = User::find()->filterWhere(['id'=>$postRequest['id']])->one();
        $model->username = $postRequest['username'];
        $model->email = $postRequest['email'];
        if($postRequest['password2'] !=''){
            $model->password_hash = md5($postRequest['password2']);
        }
        $model->updated_at = time();
        if($model->save()){
            if(isset($postRequest['role_id']) && $postRequest['role_id'] !=''){
                foreach ($postRequest['role_id'] as $value) {
                    $user_roles_model = new UserRole();
                    $user_roles_model->uid = trim($postRequest['id']);
                    $user_roles_model->roles_id = $value;
                    $user_roles_model->save();
                }
            }

            return json_encode(array('status'=>'y','message'=>'修改成功'));
        }
            return false;
    }
}