<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmOrderlist */

$this->title = 'Create Gm Orderlist';
$this->params['breadcrumbs'][] = ['label' => 'Gm Orderlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-orderlist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
