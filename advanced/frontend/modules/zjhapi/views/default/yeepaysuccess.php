
<?php
use yii\bootstrap\Alert;
?>
<div class="col-xs-12" style="padding-top: 10px;margin-top:10px">
<?php 
if (isset($params['res'])&& $params['res']['r1_Code']==1)
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
    
    $str = '<div>充值失败</div>';
    if (isset($params['res']))
    {
        $str.='<div>错误代码:<span class="text-danger">';
        $str.=$params['res']['r1_Code'];
        $str.='</span>';
        $str.=(isset($params['res']['rq_ReturnMsg'])&&$params['res']['rq_ReturnMsg']!="")?$params['res']['rq_ReturnMsg']:",请联系客服".'</div>';
    }
    echo $str;
    Alert::end();
    
    print_r($params);
}?>
</div>