<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Cfgcoinchangetype */

$this->title = 'Create Cfgcoinchangetype';
$this->params['breadcrumbs'][] = ['label' => 'Cfgcoinchangetypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfgcoinchangetype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
