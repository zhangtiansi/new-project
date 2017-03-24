<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\LogMail */

$this->title = 'Create Log Mail';
$this->params['breadcrumbs'][] = ['label' => 'Log Mails', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="log-mail-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
<script>
jQuery(function($) {
	console.log(location.hostname);
    $('.submenu li.active').removeClass("active open");
    $('.nav-list li.active').removeClass("active open");
    $('.sendmail').addClass("active");
    $('.sendmail').parent('ul').parent('li').addClass("active open");
 
});
</script>