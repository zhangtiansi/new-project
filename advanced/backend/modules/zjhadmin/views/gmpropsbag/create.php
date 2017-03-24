<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmPropsBag */

$this->title = 'Create Gm Props Bag';
$this->params['breadcrumbs'][] = ['label' => 'Gm Props Bags', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="gm-props-bag-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
