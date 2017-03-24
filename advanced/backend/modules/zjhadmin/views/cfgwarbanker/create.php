<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgWarBanker */

$this->title = 'Create Cfg War Banker';
$this->params['breadcrumbs'][] = ['label' => 'Cfg War Bankers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-war-banker-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
