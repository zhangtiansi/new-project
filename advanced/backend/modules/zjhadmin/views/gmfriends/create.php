<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmFriends */

$this->title = 'Create Gm Friends';
$this->params['breadcrumbs'][] = ['label' => 'Gm Friends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-friends-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
