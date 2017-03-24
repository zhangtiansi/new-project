#!/usr/bin/php
<?php
//print_r($argv); $argv[0]=scriptname $argv[1]=$1
$ckurl='http://bf.koudaishiji.com/world/status?id=1';
function getClient($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);//
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);// 使用自动跳转
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $output = curl_exec($ch);
    if (curl_errno($ch)) {
        echo 'Errno'.curl_error($ch);//捕抓异常
        return;
    }
    curl_close($ch);
    $output=json_decode($output);
    return $output;
}
$command = $argv[1];
if (!isset($command)) echo "Usage: world_players,world_robots,channel_players,channel_robots";
$result = getClient($ckurl);
$rr=$result->$command or 0;
echo $rr;
?>