<?php

use yii\helpers\Html;
use app\models\User;
use app\models\GmPlayerInfo;

/* @var $this yii\web\View */
/* @var $model app\models\LogCustomer */

$this->title = '赠送';
$this->params['breadcrumbs'][] = ['label' => 'Log Customers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-customer-create">
    <h1><?= Html::encode($this->title) ?></h1>

<div class="col-sm-12">
<div class="col-sm-5">
    <?= $this->render('_formgift', [
        'model' => $model,
    ]) ?>
    </div> 
</div>
</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('li.active').removeClass("active open");
    $('.agent-gift').addClass("active");
    $('.agent-gift').parent('ul').parent('li').addClass("active open");
});
</script>