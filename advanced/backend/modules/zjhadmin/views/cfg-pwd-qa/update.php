<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\CfgPwdQa */

$this->title = 'Update Cfg Pwd Qa: ' . ' ' . $model->qid;
$this->params['breadcrumbs'][] = ['label' => 'Cfg Pwd Qas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->qid, 'url' => ['view', 'id' => $model->qid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cfg-pwd-qa-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
