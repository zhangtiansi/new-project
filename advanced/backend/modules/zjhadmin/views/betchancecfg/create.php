<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgBetchance */

$this->title = 'Create Cfg Betchance';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Betchances', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-betchance-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
