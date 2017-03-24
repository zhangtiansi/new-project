<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GmAccountInfo */

$this->title = 'Update Gm Account Info: ' . ' ' . $model->gid;
$this->params['breadcrumbs'][] = ['label' => 'Gm Account Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->gid, 'url' => ['view', 'id' => $model->gid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gm-account-info-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
