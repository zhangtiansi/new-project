<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmActivity */

$this->title = 'Create Gm Activity';
$this->params['breadcrumbs'][] = ['label' => 'Gm Activities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-activity-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
