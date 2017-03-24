<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DataDailyUser */

$this->title = 'Create Data Daily User';
$this->params['breadcrumbs'][] = ['label' => 'Data Daily Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="data-daily-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
