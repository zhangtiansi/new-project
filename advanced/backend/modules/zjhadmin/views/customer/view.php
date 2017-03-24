<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\User;
use app\models\CfgProps;

/* @var $this yii\web\View */
/* @var $model app\models\LogCustomer */

$this->title = '赠送结果';
$this->params['breadcrumbs'][] = ['label' => 'Log Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-customer-view">

    <h1><?= Html::encode($this->title) ?></h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'gid',
            'point',
            ['label'=>'金币',
                'value'=>($model->coin/10000)."万",
            ],
            ['label'=>'道具',
                'value'=>$model->propid==0?$model->propid:CfgProps::getNameByid($model->propid),
            ],
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
