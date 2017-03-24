<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogMaxGamechange */

$this->title = 'Create Log Max Gamechange';
$this->params['breadcrumbs'][] = ['label' => 'Log Max Gamechanges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-max-gamechange-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
