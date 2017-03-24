<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\CfgPwdQa */

$this->title = 'Create Cfg Pwd Qa';
$this->params['breadcrumbs'][] = ['label' => 'Cfg Pwd Qas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cfg-pwd-qa-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
