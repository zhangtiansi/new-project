<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogWarResult */

$this->title = 'Create Log War Result';
$this->params['breadcrumbs'][] = ['label' => 'Log War Results', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-war-result-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
