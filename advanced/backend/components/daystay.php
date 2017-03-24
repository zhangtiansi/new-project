#!/usr/bin/php
<?php
//print_r($argv); $argv[0]=scriptname $argv[1]=$1
$dbhost="localhost";
$username="zjhread";
$userpass="zjhread_2015~";
$dbdatabase="zjh";
$imphost="115.231.174.73";
$impname='dataimport';
$imppass='dd_2015';
$impDb='zjh';

$db=new mysqli($dbhost,$username,$userpass,$dbdatabase);
if(mysqli_connect_error()){
    echo 'Could not connect to database.';
    exit;
}
$channellist=$db->query('select cid from gm_channel_info');
while($rowChannel=$channellist->fetch_row()){
    $channel = $rowChannel[0];
    //2day 
    $db2=new mysqli($imphost,$impname,$imppass,$impDb);
    $xdate=date("Y-m-d",strtotime("-2 day"));
    $dbtmp=new mysqli($dbhost,$username,$userpass,$dbdatabase);
    $q1= 'call get_user_stay("'.$xdate.'",1,'.$channel.');';
    echo $q1."\n";
    $result=$dbtmp->query($q1);
    $s_num='';
    $r_num="";
    while($row=$result->fetch_row())
    {
        $s_num=$row[1];
        $r_num=$row[2];
    }
    $dbtmp->close();
    if ($r_num!=0){
        $sql='insert into data_dailystay(udate,channel,r_num,s_num2) value ("'.$xdate.'","'.$channel.'","'.$r_num.'","'.$s_num.'")';
        echo $sql."\n";
        $res = $db2->query($sql);
        if ($res)
            echo "query insert success date: ".$xdate." channel :".$channel." \n";
    }
    $db2->close();
    
    //3day
    $dba2=new mysqli($imphost,$impname,$imppass,$impDb);
    $xdate=date("Y-m-d",strtotime("-3 day"));
    $dbtmpx=new mysqli($dbhost,$username,$userpass,$dbdatabase);
    $q1= 'call get_user_stay("'.$xdate.'",2,'.$channel.');';
    echo $q1."\n";
    $result=$dbtmpx->query($q1);
    $s_num3='';
    while($row=$result->fetch_row())
    {
        $s_num3=$row[1];
    }
    $dbtmpx->close();
    $sql='update data_dailystay set s_num3="'.$s_num3.'" where udate="'.$xdate.'" and channel="'.$channel.'")';
    echo $sql."\n";
    $res = $dba2->query($sql);
    if ($res)
        echo "query update s_num3 success  date: ".$xdate." channel :".$channel." \n";
    $dba2->close();
    
    //7day
    $dbb2=new mysqli($imphost,$impname,$imppass,$impDb);
    $xdate=date("Y-m-d",strtotime("-7 day"));
    $dbtmpb=new mysqli($dbhost,$username,$userpass,$dbdatabase);
    $q1= 'call get_user_stay("'.$xdate.'",6,'.$channel.');';
    echo $q1."\n";
    $result=$dbtmpb->query($q1);
    $s_num7='';
    while($row=$result->fetch_row())
    {
        $s_num7=$row[1];
    }
    $dbtmpb->close();
    $sql='update data_dailystay set s_num7="'.$s_num7.'" where udate="'.$xdate.'" and channel="'.$channel.'")';
    echo $sql."\n";
    $res = $dbb2->query($sql);
    if ($res)
        echo "query update s_num7 success  date: ".$xdate." channel :".$channel." \n";
    $dbb2->close();

}
$db->close();
//所有渠道的数据
$channel=999;
//2day 
    $db12=new mysqli($imphost,$impname,$imppass,$impDb);
    $xdate=date("Y-m-d",strtotime("-2 day"));
    $dbtmp=new mysqli($dbhost,$username,$userpass,$dbdatabase);
    $q1= 'call get_user_stay("'.$xdate.'",1,0);';
    echo $q1."\n";
    $result=$dbtmp->query($q1);
    $s_num='';
    $r_num="";
    while($row=$result->fetch_row())
    {
        $s_num=$row[1];
        $r_num=$row[2];
    }
    $dbtmp->close();
    if ($r_num==0) break;
    $sql='insert into data_dailystay(udate,channel,r_num,s_num2) value ("'.$xdate.'","'.$channel.'","'.$r_num.'","'.$s_num.'")';
    echo $sql."\n";
    $res = $db12->query($sql);
    if ($res)
        echo "query insert success date: ".$xdate." channel :".$channel." \n";
    $db12->close();
    
    //3day
    $db22=new mysqli($imphost,$impname,$imppass,$impDb);
    $xdate=date("Y-m-d",strtotime("-3 day"));
    $dbtmp2=new mysqli($dbhost,$username,$userpass,$dbdatabase);
    $q1= 'call get_user_stay("'.$xdate.'",2,'.$channel.');';
    echo $q1."\n";
    $result=$dbtmp2->query($q1);
    $s_num3='';
    while($row=$result->fetch_row())
    {
        $s_num3=$row[1];
    }
    $dbtmp2->close();
    $sql='update data_dailystay set s_num3="'.$s_num3.'" where udate="'.$xdate.'" and channel="'.$channel.'")';
    echo $sql."\n";
    $res = $db22->query($sql);
    if ($res)
        echo "query update s_num3 success  date: ".$xdate." channel :".$channel." \n";
    $db22->close();
    
    //7day
    $db32=new mysqli($imphost,$impname,$imppass,$impDb);
    $xdate=date("Y-m-d",strtotime("-7 day"));
    $dbtmp3=new mysqli($dbhost,$username,$userpass,$dbdatabase);
    $q1= 'call get_user_stay("'.$xdate.'",6,'.$channel.');';
    echo $q1."\n";
    $result=$dbtmp3->query($q1);
    $s_num7='';
    while($row=$result->fetch_row())
    {
        $s_num7=$row[1];
    }
    $dbtmp3->close();
    $sql='update data_dailystay set s_num7="'.$s_num7.'" where udate="'.$xdate.'" and channel="'.$channel.'");';
    echo $sql."\n";
    $res = $db32->query($sql);
    if ($res)
        echo "query update s_num7 success  date: ".$xdate." channel :".$channel." \n";
    $db32->close();
?>