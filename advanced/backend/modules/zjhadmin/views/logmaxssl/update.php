<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\LogMaxSslchange */

$this->title = 'Update Log Max Sslchange: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Max Sslchanges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="log-max-sslchange-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
