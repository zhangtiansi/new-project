<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AgentInfo */

$this->title = '创建Agent号';
$this->params['breadcrumbs'][] = ['label' => 'Agent Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelacc'=>$modelacc,
    ]) ?>

</div>
