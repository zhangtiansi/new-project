<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogGift */

$this->title = 'Create Log Gift';
$this->params['breadcrumbs'][] = ['label' => 'Log Gifts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-gift-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
