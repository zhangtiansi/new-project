<?php
namespace app\components;
use yii;
use app\components\mapapi;
use app\models\TdSummary;
use app\models\GmOrderlist;

class wechat
{
    public $ToUserName;
    public $FromUserName;
    public $CreateTime;
    public $MsgType;
    //文本消息
    public $Content;
    //图片消息
    public $PicUrl;
    public $MediaId;
    //普通的发送地理位置
    public $Location_X;
    public $Location_Y;
    public $Scale;
    public $Label;
    //事件
    public $Event;
    //菜单事件
    public $EventKey;
    //打开对话时地理位置的上报
    public $Latitude;//纬度
    public $Longitude;//经度
    public $Precision;//地理位置精度
    //菜单地图选择器上报有eventkey location_x location_y scale label Poiname
    public $Poiname;
    //消息id
    public $MsgId;
    //员工编号
    public $AgentID;
    public $postStr;
    
    
    /**
     * 
     * 文本
     * <xml>
   <ToUserName><![CDATA[toUser]]></ToUserName>
   <FromUserName><![CDATA[fromUser]]></FromUserName> 
   <CreateTime>1348831860</CreateTime>
   <MsgType><![CDATA[text]]></MsgType>
   <Content><![CDATA[this is a test]]></Content>
   <MsgId>1234567890123456</MsgId>
   <AgentID>1</AgentID>
</xml>

     * IMAGE
     * <xml>
   <ToUserName><![CDATA[toUser]]></ToUserName>
   <FromUserName><![CDATA[fromUser]]></FromUserName>
   <CreateTime>1348831860</CreateTime>
   <MsgType><![CDATA[image]]></MsgType>
   <PicUrl><![CDATA[this is a url]]></PicUrl>
   <MediaId><![CDATA[media_id]]></MediaId>
   <MsgId>1234567890123456</MsgId>
   <AgentID>1</AgentID>
</xml>

     * ++发的普通地理位置
     * <xml>
   <ToUserName><![CDATA[toUser]]></ToUserName>
   <FromUserName><![CDATA[fromUser]]></FromUserName>
   <CreateTime>1351776360</CreateTime>
   <MsgType><![CDATA[location]]></MsgType>
   <Location_X>23.134521</Location_X>
   <Location_Y>113.358803</Location_Y>
   <Scale>20</Scale>
   <Label><![CDATA[位置信息]]></Label>
   <MsgId>1234567890123456</MsgId>
   <AgentID>1</AgentID>
</xml>

     * 地理位置上报
     * <xml>
   <ToUserName><![CDATA[toUser]]></ToUserName>
   <FromUserName><![CDATA[FromUser]]></FromUserName>
   <CreateTime>123456789</CreateTime>
   <MsgType><![CDATA[event]]></MsgType>
   <Event><![CDATA[LOCATION]]></Event>
   <Latitude>23.104105</Latitude>
   <Longitude>113.320107</Longitude>
   <Precision>65.000000</Precision>
   <AgentID>1</AgentID>
</xml>
     * 菜单事件
     * <xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>123456789</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[CLICK]]></Event>
<EventKey><![CDATA[EVENTKEY]]></EventKey>
<AgentID>1</AgentID>
</xml>
     * 
     * 地图拾取
     * <xml><ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[FromUser]]></FromUserName>
<CreateTime>1408091189</CreateTime>
<MsgType><![CDATA[event]]></MsgType>
<Event><![CDATA[location_select]]></Event>
<EventKey><![CDATA[6]]></EventKey>
<SendLocationInfo><Location_X><![CDATA[23]]></Location_X>
<Location_Y><![CDATA[113]]></Location_Y>
<Scale><![CDATA[15]]></Scale>
<Label><![CDATA[ 广州市海珠区客村艺苑路 106号]]></Label>
<Poiname><![CDATA[]]></Poiname>
</SendLocationInfo>
<AgentID>1</AgentID>
</xml>
     * @param unknown $postStr
     * Https请求方式: POST
https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=ACCESS_TOKEN
     * 创建成员
     * {
   "userid": "zhangsan",
   "name": "张三",
   "department": [4],
   "position": "客户",
   "mobile": "15913215421", 
   "email": "zhangsan@gzdev.com",
   "weixinid": "zhangsan4dev",
   "extattr": {"attrs":[{"name":"爱好","value":"旅游"},{"name":"卡号","value":"1234567234"}]}
}
     * 
     * 获取media
     * https://qyapi.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=MEDIA_ID
     * 
     * 响应包
     * TEXT文本消息
     * <xml>
   <ToUserName><![CDATA[toUser]]></ToUserName>
   <FromUserName><![CDATA[fromUser]]></FromUserName> 
   <CreateTime>1348831860</CreateTime>
   <MsgType><![CDATA[text]]></MsgType>
   <Content><![CDATA[this is a test]]></Content>
</xml>
     * 
     * image 消息
     * 
     * <xml>
   <ToUserName><![CDATA[toUser]]></ToUserName>
   <FromUserName><![CDATA[fromUser]]></FromUserName>
   <CreateTime>1348831860</CreateTime>
   <MsgType><![CDATA[image]]></MsgType>
   <Image>
       <MediaId><![CDATA[media_id]]></MediaId>
   </Image>
</xml>
     *
     * news消息
     * <xml>
   <ToUserName><![CDATA[toUser]]></ToUserName>
   <FromUserName><![CDATA[fromUser]]></FromUserName>
   <CreateTime>12345678</CreateTime>
   <MsgType><![CDATA[news]]></MsgType>
   <ArticleCount>2</ArticleCount>
   <Articles>
       <item>
           <Title><![CDATA[title1]]></Title> 
           <Description><![CDATA[description1]]></Description>
           <PicUrl><![CDATA[picurl]]></PicUrl>
           <Url><![CDATA[url]]></Url>
       </item>
       <item>
           <Title><![CDATA[title]]></Title>
           <Description><![CDATA[description]]></Description>
           <PicUrl><![CDATA[picurl]]></PicUrl>
           <Url><![CDATA[url]]></Url>
       </item>
   </Articles>
</xml>
     * 
     */

    public function __construct($postStr)
    {
       if (isset($postStr) && $postStr != ""){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            
            $this->ToUserName = $postObj->ToUserName;
            $this->FromUserName = $postObj->FromUserName;
            $this->CreateTime = $postObj->CreateTime;
            $this->MsgType = $postObj->MsgType;
            $this->MsgId = $postObj->MsgId;
            $this->AgentID = $postObj->AgentID;
            $this->postStr = $postStr;
            $this->initVars($postObj);
        }
    }
    
    
    private  function initVars($postObj){
        
        switch ($postObj->MsgType)
        {
            case "text":
                Yii::error("text",'wxapi');
                $this->Content = $postObj->Content;
                break;
            case "image":
                Yii::error("image",'wxapi');
                $this->PicUrl = $postObj->PicUrl;
                $this->MediaId = $postObj->MediaId;
                break;
            case "location":
                Yii::error("location",'wxapi');
                $this->Location_X = $postObj->Location_X;
                $this->Location_Y = $postObj->Location_Y;
                $this->Scale = $postObj->Scale;
                $this->Label = $postObj->Label;
                break;
            case "event":
                Yii::error("event",'wxapi');
                $this->Event = $postObj->Event;
                switch ($postObj->Event)
                {
                    case "LOCATION"://地理位置
                        Yii::error("LOCATION");
                        $this->Latitude = $postObj->Latitude;
                        $this->Longitude = $postObj->Longitude;
                        $this->Precision = $postObj->Precision;
                        break;
                    case "click"://菜单点击
                        Yii::error("CLICK");
                        $this->EventKey = $postObj->EventKey;
                        break;
                    case "view":
                        Yii::error("VIEW");
                        $this->EventKey = $postObj->EventKey;
                        break;
                    case "location_select":
                        Yii::error("location_select");
                        $this->EventKey = $postObj->EventKey;
                        $this->Location_X = $postObj->SendLocationInfo->Location_X;
                        $this->Location_Y = $postObj->SendLocationInfo->Location_Y;
                        $this->Scale = $postObj->SendLocationInfo->Scale;
                        $this->Label = $postObj->SendLocationInfo->Label;
                        $this->Poiname = $postObj->SendLocationInfo->Poiname;
                        break;
                    case "enter_agent":
                        Yii::error("enter_agent",'wxapi');
                        $this->EventKey = $postObj->EventKey;
                        break;
                    default:
                        Yii::error("others",'wxapi');
                        return;
                }
                break;            
            default:
                Yii::error("nomarl msgtype".$postObj->MsgType,'wxapi');
                return; 
            }  
           
    }
    
    public function saveModel(){
//         $model = new WeixinPostLog();
//         $model->FromUserName = $this->FromUserName;
//         $model->AgentID = $this->AgentID;
//         $model->Ctime = $this->CreateTime;
//         $model->postStr = $this->postStr;
//         $model->MsgType = $this->MsgType;
//         $model->MsgId = $this->MsgId;
        
//         $model->Content = $this->Content or "";
//         $model->PicUrl = $this->PicUrl or "";
//         $model->MediaId = $this->MediaId or "";
//         $model->Location_X = $this->Location_X or "";
//         $model->Location_Y = $this->Location_Y or "";
//         $model->Scale = $this->Scale or "";
//         $model->Label = $this->Label or "";
//         $model->Event = $this->Event or "";
//         $model->EventKey = $this->EventKey or "";
//         $model->Latitude = $this->Latitude or "";
//         $model->Longitude = $this->Longitude or "";
//         $model->Precision = $this->Precision or "";
//         $model->Poiname = $this->Poiname or "";
        
//         if ($model->save(false)){
//             return true;
//         }else {
//             Yii::error("agentid : ".$model->AgentID);
//             Yii::error("save failed reason: ".print_r($model->getErrors(),true));
//             return false;
//         }
    }
    
    public function responseMsg(){
        Yii::error("response: ");
        $reply="__";
        switch ($this->MsgType)
        {
            case "text":
                Yii::error("text");
                $content=$this->Content;
                $reply=$this->responseText($content);
                break;
            case "image":
                Yii::error("image");
                $content="__upload a pictrue,url is :".$this->PicUrl;
                $reply=$this->responseText($content);
                break;
            case "location":
                Yii::error("location");
                $content="你发的地理位置收到，坐标是 ".$this->Location_X." , ".$this->Location_Y;
                $reply=$this->responseText($content);
                break;
            case "event":
                Yii::error("event");
                switch ($this->Event)
                {
                    case "LOCATION"://地理位置
                        Yii::error("LOCATION  ".$this->Latitude." , ".$this->Longitude,'wxapi');
                        break;
                    case "click"://菜单点击
                        Yii::error("CLICK 点击菜单事件 ".$this->EventKey,'wxapi');
//                         $content="点击菜单事件 ".$this->EventKey;
                        switch ($this->EventKey)
                        {
                            case "nearby":
                                break;
                            case "yesterday":
                                $content=GmOrderlist::getYesterdayDataWX(1);
                                $reply=$this->responseText($content);
                                break;
                            case "data_2day":
                                $content=checkdb::getSslWinner();
                                $reply=$this->responseText($content);
                                break;
                            case "data_3day":
                                $content=checkdb::getSslper();
                                $reply=$this->responseText($content);
                                break;
                            case "ssl":
                                $content=GmOrderlist::getSSLToday();
                                $reply=$this->responseText($content);
                                break;
                            case "R-today":
                                $content=checkdb::getRich();
                                $reply=$this->responseText($content);
                                break;
                            default:
                                $content="暂未开放";
                                $reply=$this->responseText($content);
                                break;
                        }
                        
//                         $reply=$this->responseText($content);
                        break;
                    case "view":
                        Yii::error("VIEW".$this->EventKey);
//                         $content="查看网页".$this->EventKey;
//                         $reply=$this->responseText($content);
                        break;
                    case "location_select":
                        Yii::error("location_select "."你发的地理位置收到，坐标是 ".$this->Location_X." , ".$this->Location_Y ."label ".$this->Label." poiName :".$this->Poiname);
                        //$content="你发的地理位置收到，坐标是 ".$this->Location_X." , ".$this->Location_Y ."label ".$this->Label." poiName :".$this->Poiname;
                        $map = new mapapi();
                        $loca = $map->GetLocation($this->Label);
                        
                        break;
                    case "enter_agent":
                        $content=GmOrderlist::getRecentDataWX();
                        $reply=$this->responseText($content);
                        break;
                    default:
                        Yii::error("others",'wxapi');
                        $content="暂时不响应此类信息";
                        $reply=$this->responseText($content);
                        return;
                }
                break;
            default:
                Yii::error("nomarl msgtype".$this->MsgType,'wxapi');
                $content="暂时不响应此类信息";
                $reply=$this->responseText($content);
                return;
        }
        Yii::error("响应content ： ".$reply);
        return $reply;
    }
    
    public function responseText($content){
        $tpl = '<xml>
                   <ToUserName><![CDATA[%s]]></ToUserName>
                   <FromUserName><![CDATA[%s]]></FromUserName> 
                   <CreateTime>%s</CreateTime>
                   <MsgType><![CDATA[text]]></MsgType>
                   <Content><![CDATA[%s]]></Content>
                </xml>';
        $str = sprintf($tpl,$this->FromUserName,$this->ToUserName,time(),$content);
        return  $str;
    }
    
    public function responseNews($arr){
        $tplnew = '<item>
                           <Title><![CDATA[%s]]></Title> 
                           <Description><![CDATA[%s]]></Description>
                           <PicUrl><![CDATA[%s]]></PicUrl>
                           <Url><![CDATA[%s]]></Url>
                       </item>';
        $tpl = '<xml>
                   <ToUserName><![CDATA[%s]]></ToUserName>
                   <FromUserName><![CDATA[%s]]></FromUserName>
                   <CreateTime>%s</CreateTime>
                   <MsgType><![CDATA[news]]></MsgType>
                   <ArticleCount>%s</ArticleCount>
                   <Articles>%s</Articles>
                </xml>';
        $count = count($arr);
        $newstr = "";
        foreach ($arr as $k=>$v){
            $title = $v['company_name'];
            $desc = "--距离 ".$v['distance']."km 已拜访".rand(5, 20).'次';
            if ($k == 0){
                $picurl = 'http://crm.wawego.com/images/customers.png';
            }else {
                $picurl = 'http://crm.wawego.com/images/client.png';
            }
            $url = 'http://crm.wawego.com/com/'.$v['id'];
            $newstr .= sprintf($tplnew,$title.$desc,$desc,$picurl,$url);
        }
        $str = sprintf($tpl,$this->FromUserName,$this->ToUserName,time(),$count,$newstr);
        return  $str;
    }
    
    
}