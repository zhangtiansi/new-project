<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DataChannelUser */

$this->title = 'Create Data Channel User';
$this->params['breadcrumbs'][] = ['label' => 'Data Channel Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-channel-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
