<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogMaxSslchange */

$this->title = 'Create Log Max Sslchange';
$this->params['breadcrumbs'][] = ['label' => 'Log Max Sslchanges', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-max-sslchange-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
