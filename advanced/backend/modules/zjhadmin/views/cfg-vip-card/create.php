<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgVipCard */

$this->title = 'Create Cfg Vip Card';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Vip Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-vip-card-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
