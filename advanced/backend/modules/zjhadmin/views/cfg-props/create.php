<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgProps */

$this->title = 'Create Cfg Props';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Props', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-props-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
