<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Dailystay */

$this->title = 'Create Dailystay';
$this->params['breadcrumbs'][] = ['label' => 'Dailystays', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dailystay-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
