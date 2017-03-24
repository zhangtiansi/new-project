<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgProducts */

$this->title = 'Create Cfg Products';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-products-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
