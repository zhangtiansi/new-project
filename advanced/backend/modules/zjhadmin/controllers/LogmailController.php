<?php

namespace app\modules\zjhadmin\controllers;

use Yii;
use app\models\LogMail;
use app\models\LogMailSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\ApiErrorCode;
use yii\data\SqlDataProvider;

/**
 * LogmailController implements the CRUD actions for LogMail model.
 */
class LogmailController extends AdmController
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
        ];
    }

    /**
     * Lists all LogMail models.
     * @return mixed
     */
    public function actionIndex()
    {
        $objPHPExcel = new \PHPExcel();
//         $searchModel = new LogMailSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $count = Yii::$app->db->createCommand('
             SELECT COUNT(*) FROM log_mail WHERE status=:status
         ', [':status' => 0])->queryScalar();
        
        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT gid,from_id as "from",title,content,ctime,`status` FROM log_mail WHERE status=:status',
            'params' => [':status' => 0],
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
//                     'age',
                    'gid' => [
                    //                         'asc' => ['gid' => SORT_ASC, 'id' => SORT_ASC],
                        'desc' => ['id' => SORT_DESC],
                        'default' => SORT_DESC,
                        'label' => 'gid',
                    ],  
                ],
            ],
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        $cy = Yii::$app->getRequest()->getQueryParam('ctype');
        if ($cy=='export')
        {
            $objectPHPExcel = new \PHPExcel();
            $objectPHPExcel->setActiveSheetIndex(0);
            
            $page_size = 52;
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
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('B1','gid');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('C1','from');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('D1','标题');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('E1','内容');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('F1','ctime');
                    $objectPHPExcel->setActiveSheetIndex(0)->setCellValue('G1','状态');
                }
                //明细的输出
                $objectPHPExcel->getActiveSheet()->setCellValue('B'.($n+2) ,$product['gid']);
                $objectPHPExcel->getActiveSheet()->setCellValue('C'.($n+2) ,$product['from']);
                $objectPHPExcel->getActiveSheet()->setCellValue('D'.($n+2) ,$product['title']);
                $objectPHPExcel->getActiveSheet()->setCellValue('E'.($n+2) ,$product['content']);
                $objectPHPExcel->getActiveSheet()->setCellValue('F'.($n+2) ,$product['ctime']);
                $objectPHPExcel->getActiveSheet()->setCellValue('G'.($n+2) ,$product['status']);
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
            header('Content-Disposition:attachment;filename="'.'邮件-'.date("Y年m月j日").'.xls"');
            $objWriter= \PHPExcel_IOFactory::createWriter($objectPHPExcel,'Excel5');
            $objWriter->save('php://output');
            
        }
        
        return $this->render('index', [
//             'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LogMail model.
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
     * Creates a new LogMail model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSend()
    {
        if (Yii::$app->getRequest()->isPost){
            $model = new LogMail();
            $model->status=0;
            $model->ctime=date('Y-m-d H:i:s');
            $model->gid=Yii::$app->getRequest()->getBodyParam('gid');
            $model->from_id=Yii::$app->getRequest()->getBodyParam('sender');
            $model->title=Yii::$app->getRequest()->getBodyParam('title');
            $model->content=Yii::$app->getRequest()->getBodyParam('content');
            if ($model->save())
                return json_encode(ApiErrorCode::$OK);
            else 
                return json_encode(['code'=>111,'msg'=>'保存失败'.print_r($model->getErrors(),true)]);
        }
    }

    
    public function actionCreate()
    {
//         $model = new LogMail();
//         $model->status=0;
//         $model->ctime=date('Y-m-d H:i:s');
//         if ($model->load(Yii::$app->request->post()) && $model->save()) {
//             return $this->redirect(['view', 'id' => $model->id]);
//         } else {
            return $this->render('mail', [
//                 'model' => $model,
            ]);
//         }
    }

    /**
     * Updates an existing LogMail model.
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
     * Deletes an existing LogMail model.
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
     * Finds the LogMail model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LogMail the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LogMail::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
