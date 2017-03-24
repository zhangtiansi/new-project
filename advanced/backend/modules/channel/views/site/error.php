<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = '错误-渠道后台';
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
        <?php 
        if ($type=='access')
        {
            echo Html::a('登录-渠道后台','login');
        }
        if ($exception!=NULL){
            echo Html::tag('p',$exception);
        }
        ?>
    </div>


</div>
