<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\GmAccountInfoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gm Account Infos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-account-info-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Gm Account Info', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'gid',
            'account_name',
            'account_pwd',
            'pwd_q',
            'pwd_a',
            // 'sim_serial',
            // 'device_id',
            // 'op_uuid',
            // 'type',
            // 'reg_channel',
            // 'reg_time',
            // 'last_login',
            // 'token',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
