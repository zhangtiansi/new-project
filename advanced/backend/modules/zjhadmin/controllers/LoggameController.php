<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\Loggame;
use app\models\LoggameSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;
use yii\web\Response;
use yii\data\Pagination;

/**
 * LogcoinController implements the CRUD actions for LogCoinRecords model.
 */
class LoggameController extends AdmController
{
 

    /**
     * Lists all LogCoinRecords models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LoggameSearch();
        if (Yii::$app->getRequest()->getQueryParam('gid',"")!="")
        {
            $dataProvider = $searchModel->search(['LoggameSearch'=>['uid'=>Yii::$app->getRequest()->getQueryParam('gid')]]);
        }elseif (Yii::$app->getRequest()->getQueryParam('gameno',"")!="" ){
            $dataProvider = $searchModel->search(['LoggameSearch'=>[
                'game_no'=>Yii::$app->getRequest()->getQueryParam('gameno'), 
            ]
            ]);
        } elseif (Yii::$app->getRequest()->getQueryParam('propid',"")!=""){
            $pamra=Yii::$app->getRequest()->getQueryParam('propid');
            $sp=explode('_', $pamra);
            $dataProvider = $searchModel->search(['LoggameSearch'=>[
                'game_no'=>isset($sp[0])?$sp[0]:0,
                'prop_id'=>isset($sp[1])?$sp[1]:0,
            ]   
            ]);
        }else{
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    } 
    
    public function actionTbs()
    { 
        $gid = Yii::$app->getRequest()->getQueryParam('gid');
        $objPHPExcel = new \PHPExcel();
        //         $searchModel = new LogMailSearch();
        //         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $count = Yii::$app->db->createCommand('
         SELECT COUNT(*)
FROM zjh.log_coin_records t1,zjh.cfg_coin_changetype t2
where uid= :gid
and t1.change_type=t2.cid
order by t1.id desc;
     ', [':gid' => $gid])->queryScalar();
        $pages = new Pagination([
            'totalCount'=>$count,
        ]);
        $cy = Yii::$app->getRequest()->getQueryParam('ctype');
        $dt =  Yii::$app->getRequest()->getQueryParam('date');
        $sql = 'SELECT t1.uid,t2.c_name,t1.change_before,t1.change_coin,t1.change_after,t1.ctime,t1.game_no,t1.prop_id
FROM zjh.log_coin_records t1,zjh.cfg_coin_changetype t2
where uid= :gid
and t1.change_type=t2.cid
order by t1.id desc;';
        if ($dt != "")
            $sql = 'SELECT t1.uid,t2.c_name,t1.change_before,t1.change_coin,t1.change_after,t1.ctime,t1.game_no,t1.prop_id
FROM gamelog.log_coin_records_'.$dt.' t1,zjh.cfg_coin_changetype t2
where uid= :gid
and t1.change_type=t2.cid
order by t1.id desc;';
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => [':gid' =>$gid],
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
                //                     'age',
                    'ctime' => [
                        'asc' => ['ctime' => SORT_ASC, 'id' => SORT_ASC],
                        'desc' => ['ctime' => SORT_DESC, 'id' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'ctime',
                    ],
                ],
            ],
            'pagination' => [
                'pageSize' => 200,
            ],
        ]);
        if ($cy=='export')
        {
            $objectPHPExcel = new \PHPExcel();
            $objectPHPExcel->setActiveSheetIndex(0);
    
            $page_size = 100;
            //             $model = new NewsSearch();
            //             $dataProvider = $model->search();
            $dataProvider->setPagination(false);
            $data = $dataProvider->getModels();
            //             $count = $dataProvider->getTotalItemCount();
            $page_count = (int)($count/$page_size) +1;
            $current_page = 0;
            $n = 0;
            foreach ( $data as $product )
            {
                if ( $n % $page_size === 0 )
                {
                    $current_page = $current_page +1;
                    //表格头的输出
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','uid');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','变更类型');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','变更前');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','变更金币');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','变更后');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','ctime');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('H1','game_no');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('I1','prop_id');
                }
                //明细的输出
                $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n+2) ,$product['uid']);
                $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n+2) ,$product['c_name']);
                $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n+2) ,$product['change_before']);
                $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n+2) ,$product['change_coin']);
                $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n+2) ,$product['change_after']);
                $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n+2) ,$product['ctime']);
                $objectPHPExcel->getActiveSheet()->setCellValue('H'.($n+2) ,$product['game_no']);
                $objectPHPExcel->getActiveSheet()->setCellValue('I'.($n+2) ,$product['prop_id']);
                //设置边框
                $currentRowNum = $n+4;
                //                 $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':G'.$currentRowNum )
                //                 ->getBorders()->getTop()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
                //                 $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':G'.$currentRowNum )
                //                 ->getBorders()->getLeft()->setBorderStyle(\PHPExcel_Style_Border::BORDER_THIN);
                //                 $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':G'.$currentRowNum )
                //                 ->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //                 $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':G'.$currentRowNum )
                //                 ->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //                 $objectPHPExcel->getActiveSheet()->getStyle('B'.($n+4).':G'.$currentRowNum )
                //                 ->getBorders()->getVertical()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $n = $n +1;
            }
    
            //设置分页显示
            //$objectPHPExcel->getActiveSheet()->setBreak( 'I55' , PHPExcel_Worksheet::BREAK_ROW );
            //$objectPHPExcel->getActiveSheet()->setBreak( 'I10' , PHPExcel_Worksheet::BREAK_COLUMN );
            $objectPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
            $objectPHPExcel->getActiveSheet()->getPageSetup()->setVerticalCentered(false);
    
    
            ob_end_clean();
            ob_start();
    
            header('Content-Type : application/vnd.ms-excel');
            header('Content-Disposition:attachment;filename="'.'变更记录-'.$gid.date("Y年m月j日").'.xls"');
            $objWriter= \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
            $objWriter->save('php://output');
    
        }
    
        return $this->render('tddetail', [
        //             'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'pages'=>$pages,
        ]); 
    }
    
    public function actionCoin()
    {
        Yii::$app->response->format=Response::FORMAT_JSON;
        $uid= Yii::$app->getRequest()->getQueryParam('uid');
        $indate= Yii::$app->getRequest()->getQueryParam('indate');
        if ($indate==""|| $indate=="undefined"||$indate==0){
            $indate=date('ymd');
        }
        $sql='CALL findUserCoin(:uid, :indate);';
        $db=Yii::$app->db_readonly;
    
        $res=$db->createCommand($sql)
                 ->bindValues([':uid'=>$uid,':indate'=>$indate])
                ->queryAll();
        $ar = ['aaData'=>$res];
        return $ar;
    }
    /**
     * Displays a single LogCoinRecords model.
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
     * Creates a new LogCoinRecords model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Loggame();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing LogCoinRecords model.
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
     * Deletes an existing LogCoinRecords model.
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
     * Finds the LogCoinRecords model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogCoinRecords the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogCoinRecords::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
