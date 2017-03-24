<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\GmNotice */

$this->title = '创建公告';
?>
<div class="gm-notice-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
