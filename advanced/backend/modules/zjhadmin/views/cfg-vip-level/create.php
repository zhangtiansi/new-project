<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgVipLevel */

$this->title = 'Create Cfg Vip Level';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Vip Levels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-vip-level-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
