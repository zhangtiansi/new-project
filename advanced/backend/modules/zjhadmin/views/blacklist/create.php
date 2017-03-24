<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogBlacklist */

$this->title = 'Create Log Blacklist';
$this->params['breadcrumbs'][] = ['label' => 'Log Blacklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-blacklist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
