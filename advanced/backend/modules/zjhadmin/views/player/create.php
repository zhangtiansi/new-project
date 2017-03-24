<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmPlayerInfo */

$this->title = 'Create Gm Player Info';
$this->params['breadcrumbs'][] = ['label' => 'Gm Player Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-player-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
