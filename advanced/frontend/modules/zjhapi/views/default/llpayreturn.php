<?php 
use yii\bootstrap\Alert;

if ($issuccess==0)
{
    Alert::begin([
    'options' => [
    'class' => 'alert-success',
    ],
    ]);
    echo '<div>充值成功，请等待服务器验证</div>';
    Alert::end();
}else {
    Alert::begin([
    'options' => [
    'class' => 'alert-danger',
    ],
    ]);
    
    echo '<div>充值失败</div>';
    Alert::end();
}
?>
