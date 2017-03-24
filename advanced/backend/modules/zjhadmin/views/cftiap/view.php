<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CfgIpayParams */

$this->title = "爱贝信息配置 id ".$model->id." 爱贝appid ".$model->appid;
$this->params['breadcrumbs'][] = ['label' => 'Cfg Ipay Params', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-ipay-params-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('添加', ['create'],   ['class' => 'btn btn-info']) ?>
        <?= Html::a('列表', ['index'],   ['class' => 'btn btn-warning']) ?>
 
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'appdesc',
            'appid',
            'privatekey:ntext',
            'platkey:ntext',
            'ctime',
        ],
    ]) ?>

</div>
