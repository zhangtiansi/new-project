<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\GmChannelInfo */

$this->title = "渠道id :".$model->cid." 渠道名：".$model->channel_name;
$this->params['breadcrumbs'][] = ['label' => 'Gm Channel Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-channel-info-view">

    <h1><?= Html::encode($this->title) ?></h1> 
    <p>
        <?= Html::a('更新渠道信息', ['update', 'id' => $model->cid], ['class' => 'btn btn-primary']) ?>
         
    </p> 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cid',
            'channel_name',
            'channel_desc',
            'opname',
//             'oppasswd',
//             'status',
            'cur_version',
            'update_url:url',
            'version_code',
            'changelog:ntext',
            'force',
            'ctime',
            [
                'label'=>'爱贝支付参数',
                'value'=>Html::a($model->iapparam->appdesc." appid编号".$model->iapparam->appid,['cftiap/view','id'=>$model->ipay]),
                'format'=>'raw'
    ],
            'iapparam.appdesc',
//             'inreviewstat',
            [
            'label'=>'审核状态：',
                'value'=> $model->inreviewstat==1?"审核中":"已上线"."(审核中且build号大于等于下方审核build无法送礼点当，自动开启ipv6)", 
             ],
            'inreviewbuild',
        ],
    ]) ?>

</div>
