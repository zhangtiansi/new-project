<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogFriendadd */

$this->title = 'Create Log Friendadd';
$this->params['breadcrumbs'][] = ['label' => 'Log Friendadds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-friendadd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
