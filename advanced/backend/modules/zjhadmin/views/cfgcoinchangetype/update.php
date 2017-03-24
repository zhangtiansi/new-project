<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Cfgcoinchangetype */

$this->title = 'Update Cfgcoinchangetype: ' . ' ' . $model->cid;
$this->params['breadcrumbs'][] = ['label' => 'Cfgcoinchangetypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cid, 'url' => ['view', 'id' => $model->cid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="cfgcoinchangetype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
