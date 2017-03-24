<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgDailyReward */

$this->title = 'Create Cfg Daily Reward';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Daily Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-daily-reward-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
