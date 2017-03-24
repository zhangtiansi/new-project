<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\AgentInfo */

$this->title = $model->agent_name;
$this->params['breadcrumbs'][] = ['label' => 'Agent Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$arstatus = ['正常','禁止登录'];
?>
<div class="agent-info-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php 
//         echo Html::a('Delete', ['delete', 'id' => $model->id], [
//             'class' => 'btn btn-danger',
//             'data' => [
//                 'confirm' => 'Are you sure you want to delete this item?',
//                 'method' => 'post',
//             ],
//         ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//             'id',
            ['attribute'=>'account_id',
              'value'=>$model->account->username,    
            ],
            'agent_name',
            'money',
            ['attribute'=>'status',
            'value'=>$arstatus[$model->account->status],
            ],
            'agent_desc',
        ],
    ]) ?>

</div>
