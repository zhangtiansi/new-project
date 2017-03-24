<?php

namespace app\modules\newzjhadmin\controllers;

use app\models\UserRole;
use Yii;
use app\models\GmChannelInfo;
use app\models\GmChannelInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;
use app\models\CfgIpayParams;


class ChannelController extends AdmController
{
    public function actionIndex(){
        $request = Yii::$app->request;
        $getRequest = $request->get();
        $searchModel = new GmChannelInfoSearch();
        $result = $searchModel->new_search($getRequest);
        if(isset($getRequest['channel_name']) && $getRequest['channel_name'] !=''){
            $channel_name = $getRequest['channel_name'];
        }else{
            $channel_name = '';
        }
        return $this->render('index',['list'=>$result['0'],'pagination'=>$result['1'],'count'=>$result['2'],'channel_name'=>$channel_name]);
    }

    public function actionUpdate(){
        $request = Yii::$app->request;
        $postRequest = $request->post();
        $channel_model = GmChannelInfo::find()->filterWhere(['cid'=>$postRequest['gm_channel_info']['cid']])->one();
        if($postRequest['user']['id'] !=''){
            $id = $postRequest['user']['id'];
            $user_model = User::find()->filterWhere(['id'=>$id])->one();
            $user_model -> username = $postRequest['user']['username'];
            if($postRequest['user']['newpasswd'] !=''){
                $user_model -> password_hash = md5($postRequest['user']['newpasswd']);
            }
            $user_model -> status = $postRequest['user']['status'];
            $user_model->userdisplay = $postRequest['user']['userdisplay'];
            $user_model->updated_at = time();
            if(!$user_model->update()){
                return false;
            }
            UserRole::deleteAll('uid=:uid',[':uid' => $id]);
            if($postRequest['role_id'] !=''){
                foreach($postRequest['role_id'] as $value){
                    $user_roles_model = new UserRole();
                    $user_roles_model->uid = $id;
                    $user_roles_model->roles_id = $value;
                    $user_roles_model->save();
                }
            }
        }else{
            $user_model = new User();
            $user_model->username = $postRequest['user']['username'];
            $user_model->password_hash = $postRequest['user']['newpasswd'];
            $user_model->userdisplay = $postRequest['user']['userdisplay'];
            $user_model->status = $postRequest['user']['status'];
            $user_model->updated_at = time();
            $user_model->created_at = time();
            if(!$user_model->save()){
                return false;
            }
            $id = $user_model->id;
            if($postRequest['role_id'] !=''){
                foreach($postRequest['role_id'] as $value){
                    $user_roles_model = new UserRole();
                    $user_roles_model->uid = $id;
                    $user_roles_model->roles_id = $value;
                    $user_roles_model->save();
                }
            }
        }
//        var_dump($id);exit;
        $channel_model ->channel_name = $postRequest['gm_channel_info']['channel_name'];
        $channel_model ->channel_desc = $postRequest['gm_channel_info']['channel_desc'];
        $channel_model ->any_channel = $postRequest['gm_channel_info']['any_channel'];
        $channel_model ->opname = trim($id);
        $channel_model ->status = $postRequest['user']['status'];
        $channel_model ->cur_version = $postRequest['gm_channel_info']['cur_version'];
        $channel_model ->update_url = $postRequest['gm_channel_info']['update_url'];
        $channel_model ->version_code = $postRequest['gm_channel_info']['version_code'];
        $channel_model ->changelog = $postRequest['gm_channel_info']['changelog'];
        $channel_model ->force = $postRequest['gm_channel_info']['force'];
        $channel_model ->ctime = date('Y-m-d H:i:s',time());
        $channel_model ->p_user = $postRequest['gm_channel_info']['p_user'];
        $channel_model ->p_recharge = $postRequest['gm_channel_info']['p_recharge'];
        $channel_model ->p_gm = $postRequest['gm_channel_info']['p_gm'];
        $channel_model ->pay_method = $postRequest['gm_channel_info']['pay_method'];
        $channel_model ->ipay = $postRequest['gm_channel_info']['ipay'];
        $channel_model ->inreviewbuild = $postRequest['gm_channel_info']['inreviewbuild'];
        $channel_model ->inreviewstat = $postRequest['gm_channel_info']['inreviewstat'];
        if (!$channel_model->save()) {
            return false;
        }
        return json_encode(array('status'=>'y','message'=>'修改成功'));

    }

    public function actionCreate(){
        $request = Yii::$app->request;
        $postRequest = $request->post();
        $user_model = new User();
        $user_model -> username = $postRequest['user']['username'];
        $user_model -> password_hash = $postRequest['user']['newpasswd'];
        $user_model -> status = $postRequest['user']['status'];
        $user_model -> userdisplay = $postRequest['user']['userdisplay'];
        $user_model -> updated_at = time();
        $user_model -> role = 1;
        if($user_model->save()){
            $id = $user_model->id;
            if($postRequest['role_id'] !=''){
                foreach ($postRequest['role_id'] as $value) {
                    $user_roles_model = new UserRole();
                    $user_roles_model->uid = $id;
                    $user_roles_model->roles_id = $value;
                    $user_roles_model->save();
                }

            }
            $db=Yii::$app->db;
            $result = $db->createCommand('INSERT INTO `gm_channel_info` (`channel_name`,`channel_desc`,`any_channel`,`opname`,`status`,`cur_version`,`update_url`,`version_code`,`changelog`,`force`,`ctime`,`p_user`,`p_recharge`,`p_gm`,`pay_method`,`ipay`,`inreviewbuild`,`inreviewstat`) VALUES (:channel_name,:channel_desc,:any_channel,:opname,:status,:cur_version,:update_url,:version_code,:changelog,:force,:ctime,:p_user,:p_recharge,:p_gm,:pay_method,:ipay,:inreviewbuild,:inreviewstat)', [':channel_name' => $postRequest['gm_channel_info']['channel_name'],':channel_desc'=>$postRequest['gm_channel_info']['channel_desc'],':any_channel'=>$postRequest['gm_channel_info']['any_channel'],':opname'=>$id,':status'=>$postRequest['user']['status'], ':cur_version'=>$postRequest['gm_channel_info']['cur_version'],':update_url'=>$postRequest['gm_channel_info']['update_url'],':version_code'=>$postRequest['gm_channel_info']['version_code'],':changelog'=>$postRequest['gm_channel_info']['changelog'], ':force'=>$postRequest['gm_channel_info']['force'],':ctime'=>date('Y-m-d H:i:s',time()),':p_user'=>$postRequest['gm_channel_info']['p_user'],':p_recharge'=>$postRequest['gm_channel_info']['p_recharge'],':p_gm'=>$postRequest['gm_channel_info']['p_gm'], ':pay_method'=>$postRequest['gm_channel_info']['pay_method'],':ipay'=>$postRequest['gm_channel_info']['ipay'],':inreviewbuild'=>$postRequest['gm_channel_info']['inreviewbuild'],':inreviewstat'=>$postRequest['gm_channel_info']['inreviewstat']])->execute();
            if ($result) {
                return json_encode(array('status'=>'y','message'=>'添加成功'));
            }
        }
        return false;
    }

    public function actionView(){
        $request = Yii::$app->request;
        $cid = $request->get();
        $gm_channel_result = GmChannelInfo::find()->filterWhere(['cid'=>$cid])->one();
        $ipay_model = CfgIpayParams::find()->filterWhere(['id'=>$gm_channel_result->ipay])->one();
        return $this->render('view',['gm_channel_result'=>$gm_channel_result,'ipay_model'=>$ipay_model]);
    }

    public function actionFinduser(){
        $request = Yii::$app->request;
        $username = $request->get();
        $user_result = User::find()->filterWhere(['username'=>$username])->one();
        if($user_result ==''){
            echo 0;
        }else{
            echo 1;
        }
    }

    public function actionThequerypassword(){
        $request = Yii::$app->request;
        $result = $request->get();
        $user_result = User::find()->filterWhere(['id'=>$result['user_id']])->one();
        if($user_result ==''){
            echo 0;
        }
        if($user_result['password_hash'] != md5($result['password'])){
            echo 0;
        }
        echo 1;

    }
}