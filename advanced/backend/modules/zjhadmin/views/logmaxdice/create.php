<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogMaxDicechange */

$this->title = 'Create Log Max Dicechange';
$this->params['breadcrumbs'][] = ['label' => 'Log Max Dicechanges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-max-dicechange-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
