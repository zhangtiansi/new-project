<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmOptact */

$this->title = 'Create Gm Optact';
$this->params['breadcrumbs'][] = ['label' => 'Gm Optacts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-optact-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
