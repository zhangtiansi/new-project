<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogFriendsMsgs */

$this->title = 'Create Log Friends Msgs';
$this->params['breadcrumbs'][] = ['label' => 'Log Friends Msgs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-friends-msgs-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
