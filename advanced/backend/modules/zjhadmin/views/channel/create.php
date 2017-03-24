<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmChannelInfo */

$this->title = 'Create Gm Channel Info';
$this->params['breadcrumbs'][] = ['label' => 'Gm Channel Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-channel-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelacc'=>$modelacc,
    ]) ?>

</div>
