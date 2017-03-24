<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgBetconfig */

$this->title = 'Create Cfg Betconfig';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Betconfigs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-betconfig-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
