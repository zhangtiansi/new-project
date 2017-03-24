<?php
namespace app\components;
use Yii;
class AnySDK{

    /**
     * anysdk 支付通知白名单判断
     */
    public static function checkAnySDKSever() {
        $AnySDKServerIps = array('211.151.20.126', '211.151.20.127');
        $remoteIp = $_SERVER['REMOTE_ADDR'];
        if (!in_array($remoteIp, $AnySDKServerIps)) {
            echo "remote address is illegal.";
            return false;
        }else
            return TRUE;
    }
    
    /**
     * 检测道具金额与实际金额是否一致，开发者根据实际情况自己实现判断方式
     * @param type $params
     */
    public static function checkAmount($params) {
        if (getProductAmount($params['product_id']) != $params['amount']) {
            echo 'Purchase is illegal. order_id:' . $params['order_id'];
            exit;
        }
    }
    
    /**
     * 获取道具在服务器上的金额
     * @param type $productId
     * @return int 单位元
     */
    function getProductAmount($productId) {
        //get amount by productId
        return 1;
    }
    
    /**
     * 通用验签
     * @param array $data 接收到的所有请求参数数组，通过$_POST可以获得。注意data数据如果服务器没有自动解析，请做一次urldecode(参考rfc1738标准)处理
     * @param array $privateKey AnySDK分配的游戏privateKey
     * @return bool
     */
    public function checkSign($data, $privateKey) {
        if (empty($data) || !isset($data['sign']) || empty($privateKey)) {
            Yii::error("data empty? sign not set ? privatekey empty?","anysdk");
            return false;
        }
//         $data=$this->urldecode($data);
        $sign = $data['sign'];
        //sign 不参与签名
        unset($data['sign']);
        $_sign = $this->getSign($data, $privateKey);
        if ($_sign != $sign) {
            Yii::error("get sign: ".$_sign." data sign: ".$sign);
            return false;
        }
        return true;
    }
    /**
     * URL Decode.
     * @param mixed $item Item to url decode.
     * @return string URL decoded string.
     */
    public function urldecode($item) {
        if (is_array($item)) {
            return array_map(array(&$this, 'urldecode'), $item);
        }
    
        return urldecode($item);
    }
    /**
     * 增强验签
     * @param type $data
     * @param type $enhancedKey
     * @return boolean
     */
    public function checkEnhancedSign($data, $enhancedKey) {
        if (empty($data) || !isset($data['enhanced_sign']) || empty($enhancedKey)) {
            return false;
        }
        $enhancedSign = $data['enhanced_sign'];
        //sign及enhanced_sign 不参与签名
        unset($data['sign'], $data['enhanced_sign']);
        $_enhancedSign = $this->getSign($data, $enhancedKey);
        if ($_enhancedSign != $enhancedSign) {
            return false;
        }
        return true;
    }
    
    /**
     * 计算签名
     * @param array $data
     * @param string $key
     * @return string
     */
    function getSign($data, $key) {
    
        //数组按key升序排序
        ksort($data);
        Yii::error("getSign ksort ".print_r($data,true),"anysdk");
        //将数组中的值不加任何分隔符合并成字符串
        $string = implode('', $data);
        Yii::error("getSign implode ".$string,"anysdk");
        //第一次md5并转换成小写
        $theFirstMd5String = strtolower(md5($string));

        Yii::error("getSign theFirstMd5String ".$theFirstMd5String,"anysdk");
        //追加privatekey
        $addPrivateKeyString = $theFirstMd5String . $key;

        Yii::error("getSign addPrivateKeyString ".$addPrivateKeyString,"anysdk");
        //第二次md5并转换成小写
        $theLastMd5String = strtolower(md5($addPrivateKeyString));

        Yii::error("getSign strtolower ".$theLastMd5String,"anysdk");
        return $theLastMd5String;
        //        return strtolower(md5(strtolower(md5($string)) . $privateKey));
    }
    
}