<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;

/* @var $this yii\web\View */
/* @var $model app\models\LogCustomer */

$this->title = '赠送结果';
$this->params['breadcrumbs'][] = ['label' => 'Log Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-customer-view">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <?= Html::a('继续充值', ['recharge'], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('返回列表', ['index'], ['class' => 'btn btn-warning']) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'gid',
            'point',
            ['label'=>'金币',
                'value'=>($model->coin/10000)."万",
            ],
            'propid',
            'propnum',
            'card_g',
            'card_s',
            'card_c',
            ['label'=>'操作人',
                'format'=>'raw',
                'value'=>$model->status==2?"赠送成功":"创建成功"
             ],
            'ctime',
            ['label'=>'操作人','value'=>User::getNamebyid($model->ops)],
            'desc',
        ],
    ]) ?>

</div>
