<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\GmOrderlist */

$this->title = 'Update Gm Orderlist: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Gm Orderlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="gm-orderlist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
