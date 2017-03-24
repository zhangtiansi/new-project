<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\GmPlayerInfo;
use app\models\GmPlayerInfoSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ApiErrorCode;
use app\components\AliyunClient;
use app\components\Cdn20141111RefreshObjectCachesRequest;
use app\models\LogHourPlayerinfo;

/**
 * PlayerController implements the CRUD actions for GmPlayerInfo model.
 */
class PlayerController extends AdmController
{
 
    /**
     * Lists all GmPlayerInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id = Yii::$app->getRequest()->getQueryParam('id');
        return $this->render('index',[
            'model' => $this->findModel($id),
        ]);
//         $searchModel = new GmPlayerInfoSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

//         return $this->render('index', [
//             'searchModel' => $searchModel,
//             'dataProvider' => $dataProvider,
//         ]);
    }

    /**
     * Displays a single GmPlayerInfo model.
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
     * Creates a new GmPlayerInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new GmPlayerInfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->account_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionHis($gid)
    {
        $gdata=LogHourPlayerinfo::getHis($gid);
        $data=[];
        $gdata=array_reverse($gdata);
        foreach ($gdata as $k=>$v){
            array_push($data, [$v['chour'],$v['money']/10000]);
        }
        return json_encode($data);
    }
    
    public function actionHischange($gid)
    {
        $gdata=LogHourPlayerinfo::getHisCoin($gid);
        return json_encode($gdata);
    }
    
    public function actionResetavatar()
    {
        $gid = Yii::$app->getRequest()->getQueryParam('gid');
        $file = Yii::$app->params['avatarPath'].$gid.".jpg";
        $default = Yii::$app->params['avatarPath'].rand(1, 388).".jpg";
        Yii::error('the file path is '.$file);
        if (file_exists($default))
        {
            Yii::error("default file is exist ,now replace ");
            $img = file_get_contents($default);
            $picdata=base64_encode($img);
            $post_data="gid=".$gid."&picdata=".$picdata;
            Yii::error("resetpost data: ".$post_data);
            $res = $this->postClient("http://g.koudaishiji.com/avatar", $post_data);
//             $a=file_put_contents($file, $img);
            if ($res){
                //@todo refresh url on cdn
                //"https://cdn.aliyuncs.com?&Action=RefreshObjectCaches&ObjectPath=g.koudaishiji.com/images/avatars/".$gid.".jpg&ObjectType=File&<公共请求参数>"
                $result=$this->getClient("http://120.26.129.162/aliyun-cdn/cdn_refresh.php?gid=".$gid);
                Yii::error($res);
                return json_encode(ApiErrorCode::$OK);
            }else {
                $result=json_encode(['code'=>1111,'msg'=>'请求失败。'.$res]);
                Yii::error($result);
                return $result;
            }
        }
        return json_encode(ApiErrorCode::$SAVEERR);
    }
    function getClient($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);//捕抓异常
            return;
        }
        curl_close($ch);
        // 		var_dump($output);
        // 		print_r($output);
        $output=json_decode($output);
        return $output;
    }
    function postClient($url,$post_data){//POST方法
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);//
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
        curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Errno'.curl_error($ch);//捕抓异常
            return false;
        }
        curl_close($ch);
        $output=json_decode($output);
        return $output;
    }
    /**
     * Updates an existing GmPlayerInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        $model = $this->findModel($id);
        $model->setScenario('modify');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->account_id]);
        } else {
            if ($model->getErrors()){
                yii::error(print_r($model->getErrors(),true));
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GmPlayerInfo model.
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
     * Finds the GmPlayerInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GmPlayerInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GmPlayerInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
