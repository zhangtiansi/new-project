<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\LogUserrequstSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '玩家请求信息';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-userrequst-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'gid',
            'keyword',
            'osver',
            'appver',
            'lineNo',
            'uuid',
            'simSerial',
            'dev_id',
            'channel',
            'ctime',
            'request_ip',

        ],
    ]); ?>

</div>
