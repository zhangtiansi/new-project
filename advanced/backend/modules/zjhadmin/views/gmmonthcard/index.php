<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmMonthCardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gm Month Cards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-month-card-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('月卡记录', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], 
            'gid',
            'firstbg_tm',
            [
                'label'=>'过期时间',
                'value'=>function($model)
                {
                    return date('Y-m-d H:i:s' ,(strtotime($model->lastbuy_tm)+$model->buy_tm)); 
                }
                ],
            'buy_tm',
            'lastbuy_tm',
            'lastget_tm', 
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
