<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgWarPlayerBanker */

$this->title = 'Create Cfg War Player Banker';
$this->params['breadcrumbs'][] = ['label' => 'Cfg War Player Bankers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-war-player-banker-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
