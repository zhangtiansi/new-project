<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgGiftReward */

$this->title = 'Create Cfg Gift Reward';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Gift Rewards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-gift-reward-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
