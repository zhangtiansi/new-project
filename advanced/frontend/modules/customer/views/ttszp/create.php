<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Ttszp */

$this->title = 'Create Ttszp';
$this->params['breadcrumbs'][] = ['label' => 'Ttszps', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ttszp-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
