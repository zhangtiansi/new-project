<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GmPlayerInfo */

$this->title = 'Update Gm Player Info: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Gm Player Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->account_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gm-player-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
