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
    for ($i=2;$i<70;$i++){
        $db2=new mysqli($imphost,$impname,$imppass,$impDb);
        $xdate=date("Y-m-d",strtotime("-".$i." day"));
        
        //2day
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
            //3day
            $dbtmp=new mysqli($dbhost,$username,$userpass,$dbdatabase);
            $q2= 'call get_user_stay("'.$xdate.'",2,'.$channel.');';
            echo $q2."\n";
            $result3=$dbtmp->query($q2);
            $s_num3='';
            if ($result3){
                while($row3=$result3->fetch_row())
                {
                    $s_num3=$row3[1];
                }
            }else {
                echo "Failed to query s_num3 \n";
            }
            $dbtmp->close();
            //7day
            $dbtmp=new mysqli($dbhost,$username,$userpass,$dbdatabase);
            $q3= 'call get_user_stay("'.$xdate.'",6,'.$channel.');';
            echo $q3."\n";
            $result7=$dbtmp->query($q3);
            $s_num7='';
            if ($result7){
                while($row7=$result7->fetch_row())
                {
                    $s_num7=$row7[1];
                }
            }else {
                echo "Failed to query s_num7 \n";
            }
            $dbtmp->close();
            $sql='insert into data_dailystay(udate,channel,r_num,s_num2,s_num3,s_num7) value ("'.$xdate.'","'.$channel.'","'.$r_num.'","'.$s_num.'","'.$s_num3.'","'.$s_num7.'");';
            echo $sql."\n";
            $res = $db2->query($sql);
            if ($res)
                echo "query insert success date: ".$xdate." channel :".$channel." \n";
        }
        $db2->close();
    }	
}
$db->close();
//所有渠道的数据
$channel=999;
for ($i=2;$i<70;$i++){
    $db2=new mysqli($dbhost,$username,$userpass,$dbdatabase);
    $xdate=date("Y-m-d",strtotime("-".$i." day"));

    //2day
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
    if ($r_num!=0){
        //3day
        $dbtmp=new mysqli($dbhost,$username,$userpass,$dbdatabase);
        $q2= 'call get_user_stay("'.$xdate.'",2,'.$channel.');';
        echo $q2."\n";
        $result3=$dbtmp->query($q2);
        $s_num3='';
        if ($result3){
            while($row3=$result3->fetch_row())
            {
                $s_num3=$row3[1];
            }
        }else {
            echo "Failed to query s_num3 \n";
        }
        $dbtmp->close();
        //7day
        $dbtmp=new mysqli($dbhost,$username,$userpass,$dbdatabase);
        $q3= 'call get_user_stay("'.$xdate.'",6,'.$channel.');';
        echo $q3."\n";
        $result7=$dbtmp->query($q3);
        $s_num7='';
        if ($result7){
            while($row7=$result7->fetch_row())
            {
                $s_num7=$row7[1];
            }
        }else {
            echo "Failed to query s_num7 \n";
        }
        $dbtmp->close();
        $sql='insert into data_dailystay(udate,channel,r_num,s_num2,s_num3,s_num7) value ("'.$xdate.'","'.$channel.'","'.$r_num.'","'.$s_num.'","'.$s_num3.'","'.$s_num7.'");';
        echo $sql."\n";
        $res = $db2->query($sql);
        if ($res)
            echo "query insert success date: ".$xdate." channel :".$channel." \n";
    }
    $db2->close();
}
?>