<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmNotice */

$this->title = 'Create Gm Notice';
$this->params['breadcrumbs'][] = ['label' => 'Gm Notices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-notice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
