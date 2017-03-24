<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogFriendsMsgs */

$this->title = 'Update Log Friends Msgs: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Friends Msgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-friends-msgs-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
