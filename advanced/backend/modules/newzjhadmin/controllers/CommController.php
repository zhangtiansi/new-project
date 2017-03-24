<?php

namespace app\modules\newzjhadmin\controllers;

use app\models\PermissionRole;
use app\models\Roles;
use app\models\UserRole;
use Yii;
use app\models\GmChannelInfo;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\User;
use app\models\CfgIpayParams;
use app\models\Permission;


class CommController extends Controller
{

    public $layout = 'layout';

    public function actionChannel(){
        $permission = $this->permissioncheck();
        if($permission === false){
            echo '你无权访问该页面';exit;
        }
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $cid = $getRequest['id'];
        $result = GmChannelInfo::find()->filterWhere(['cid'=>$cid])->one();
        if(!empty($result->opname)){
            $user = User::find()->filterWhere(['id'=>$result->opname])->one();
            $user_roles_result  = UserRole::find()->filterWhere(['uid'=>$result->opname])->all();
            $user_roles_id = '';
            foreach($user_roles_result as $value){
                $user_roles_id[] = $value->roles_id;
            }
        }
        $role_list = Roles::find()->all();
        $ipay_model = new CfgIpayParams();
        $ipay_list = $ipay_model->getIappayDropList();
        return $this->render('channel',['result'=>$result,'user'=>isset($user) && $user !='' ? $user : new User(),'ipay_list'=>$ipay_list,'role_list'=>$role_list,'user_roles_id'=>isset($user_roles_id) && $user_roles_id !='' ? $user_roles_id : '']);
    }

    public function actionCreatechannel(){
        $permission = $this->permissioncheck();
        if($permission === false){
            echo '你无权访问该页面';exit;
        }
        $ipay_model = new CfgIpayParams();
        $role_list = Roles::find()->all();
        $ipay_list = $ipay_model->getIappayDropList();
        return $this->render('createchannel',['ipay_list'=>$ipay_list,'role_list'=>$role_list]);
    }

    public function actionCreatepermission(){
        $permission = $this->permissioncheck();
        if($permission === false){
            echo '你无权访问该页面';exit;
        }
        return $this->render('createpermission');
    }
    public function actionUpdatepermission(){
        $permission = $this->permissioncheck();
        if($permission === false){
            echo '你无权访问该页面';exit;
        }
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $id = $getRequest['id'];
        $result = Permission::find()->filterWhere(['id'=>$id])->one();
        return $this->render('updatepermission',['permission_result'=>$result]);
    }
    public function actionCreateuser(){
        $permission = $this->permissioncheck();
        if($permission === false){
            echo '你无权访问该页面';exit;
        }
        $user_result = Roles::find()->all();
        return $this->render('createuser',['list'=>$user_result]);
    }

    public function actionUpdateuser(){
        $permission = $this->permissioncheck();
        if($permission === false){
            echo '你无权访问该页面';exit;
        }
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $roles_result = Roles::find()->all();
        $user_result = User::find()->filterWhere(['id'=>$getRequest['id']])->one();
        $user_roles_result = UserRole::find()->filterWhere(['uid'=>$user_result->id])->all();
        $user_roles_id = '';
        foreach ($user_roles_result as $val) {
            $user_roles_id[] = $val->roles_id;
        }
        return $this->render('updateuser',['list'=>$roles_result,'user'=>$user_result,'user_roles_id'=>$user_roles_id]);
    }

    public function actionCreateroles(){
        $permission = $this->permissioncheck();
        if($permission === false){
            echo '你无权访问该页面';exit;
        }
        $user_result = Permission::find()->all();
        return $this->render('createroles',['list'=>$user_result]);
    }

    public function actionUpdaterole(){
        $permission = $this->permissioncheck();
        if($permission === false){
            echo '你无权访问该页面';exit;
        }
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $role_result = Roles::find()->filterWhere(['id'=>$getRequest['id']])->one();
        $permission_id_list = PermissionRole::find()->filterWhere(['roles_id'=>$getRequest['id']])->all();
        $permission_id = '';
        foreach($permission_id_list as $value){
            $permission_id[] = $value->permission_id;
        }
        $permission_list = Permission::find()->all();
//        $permission_role_list = Permission::find()->filterWhere(['in','id',$permission_id])->all();
        return $this->render('updaterole',['role'=>$role_result,'permission_id'=>$permission_id,'list'=>$permission_list]);
    }

    public function actionFinduser(){
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $user_result = User::find()->filterWhere(['username'=>trim($getRequest['name'])])->one();
        if($user_result !=''){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function actionFinduserdisplay(){
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $display_user_result = User::find()->filterWhere(['userdisplay'=>trim($getRequest['display_name'])])->one();
        if($display_user_result !=''){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function actionRolesfind(){
        $request = Yii::$app->request;
        $getRequest = $request->get();
        if(isset($getRequest['name'])){
            $roles_name_result = Roles::find()->filterWhere(['name'=>trim($getRequest['name'])])->one();
            if($roles_name_result !=''){
                echo 1;exit;
            }
        }
        if(isset($getRequest['display_name'])){
            $roles_display_name_result = Roles::find()->filterWhere(['display_name'=>$getRequest['display_name']])->one();
            if($roles_display_name_result !=''){
                echo 1;exit;
            }
        }
        echo 0;exit;
    }

    public function actionPermissionfind(){
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $permission_name_result = '';
        $permission_display_name_result = '';
        $permission_route = '';
        if(isset($getRequest['name']) && $getRequest['name'] !=''){
            $permission_name_result = Permission::find()->filterWhere(['name'=>$getRequest['name']])->one();
        }
        if(isset($getRequest['display_name']) && $getRequest['display_name'] !=''){
            $permission_display_name_result = Permission::find()->filterWhere(['display_name'=>$getRequest['display_name']])->one();
        }
        if(isset($getRequest['route'])){
            $permission_route = Permission::find()->filterWhere(['route'=>trim($getRequest['route'])])->one();
        }
        if($permission_name_result !='' || $permission_display_name_result !='' || $permission_route !=''){
            echo 1;exit;
        }
        echo 0;exit;
    }

    /*权限检查公共方法*/

    public function permissioncheck(){
        $user = User::findIdentity(Yii::$app->user->id);
        if(is_object($user)){
            return ($user->checkPermission($user->id));
        }else{
            echo '你无权访问该页面';exit;
        }
    }
}