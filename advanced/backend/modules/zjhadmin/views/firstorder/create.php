<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmAccountInfo */

$this->title = 'Create Gm Account Info';
$this->params['breadcrumbs'][] = ['label' => 'Gm Account Infos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-account-info-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
