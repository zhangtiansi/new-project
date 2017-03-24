<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use app\models\Permission;
use app\models\PermissionRole;
use app\models\Roles;
use app\models\UserRole;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $role
 * @property string $roledesc
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const  ROLE_ADMIN = 1;
    const  ROLE_AGENT_ADMIN = 2;
    const  ROLE_AGENT = 3;
    const  ROLE_CUSTOMER = 4;//客服
    const  ROLE_CHANNEL_CPS =5;
    const  ROLE_CHANNEL_CPA =6; //
    const  ROLE_OPS = 7;//只能操作不能看数据
    const  ROLE_DATA = 8; //只能看数据
    const  ROLE_BUSS = 9; //只能看数据和渠道后台
    public  $newpasswd="";
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', ], 'required'],
            [['status', 'created_at', 'updated_at', 'role'], 'integer'],
            [['username','newpasswd', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['userdisplay','newpasswd','password_hash'],'safe'],
            [['auth_key'], 'string', 'max' => 32],
            [['roledesc'], 'string', 'max' => 20],
            [['username'], 'unique']
        ];
    }
    
    public function scenarios()
    {
        return [
            'agent' => ['username', 'password_hash', 'newpasswd','status', 'created_at', 'updated_at', 'role', 'card_s', 'card_c', 'status','ctime','ops','desc'],
            'customer' => [ 'gid', 'point', 'coin', 'propid', 'propnum', 'updated_at', 'card_g', 'card_s', 'card_c', 'status','ctime','ops','desc'],
            'default' => ['username', 'password_hash', 'newpasswd','status', 'created_at', 'updated_at', 'role', 'card_s', 'card_c', 'status','ctime','ops','desc'],
            'channel' => ['username', 'password_hash', 'newpasswd','status', 'created_at', 'updated_at', 'role', 'card_s', 'card_c', 'status','ctime','ops','desc'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '登录用户名',
            'userdisplay'=>'用户显示名',
            'auth_key' => 'Auth Key',
            'password_hash' => '密码',
            'password_reset_token' => 'Password Reset Token',
            'email' => '邮箱',
            'status' => '状态',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'role' => '角色',
            'roledesc' => '角色描述',
            'newpasswd'=>'新密码',
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }
    
    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }
    
        return null;
    }
    
    public function genPasswd($pwd)
    {
        return md5($pwd);
    }
    
    public function checkRole($Role)
    {
        if ($this->role == self::ROLE_ADMIN)
            return true;
        if ($this->role==self::ROLE_AGENT_ADMIN && $Role==self::ROLE_AGENT)//总Agent
            return true;
        if ($this->role == $Role)
        {
            return true;
        }else {
            return false;
        }
        
    }

    public function checkPermission($user_id){
        $db=Yii::$app->db;
        $sql = 'select `roles_id` from `user_role` where `uid` = '.$user_id;
        $role_id_list = $db->createCommand($sql)
            ->queryAll();
        if(empty($role_id_list)){
            return true;
        }
        $role_id = '';
        foreach($role_id_list as $key=>$value){
            $role_id[] = $value['roles_id'];
        }
        $permission_id_list = PermissionRole::find()->filterWhere(['in','roles_id',$role_id])->all();
        $permission_id = '';
        foreach($permission_id_list as $key=>$value){
            $permission_id[] = $value['permission_id'];
        }
        $permission_id = array_unique($permission_id);
        $permission_list = Permission::find()->filterWhere(['in','id',$permission_id])->all();
        $route_list = '';
        foreach($permission_list as $val){
            $route_list[] = $val->route;
        }
        $url_result = explode('?',$_SERVER['REQUEST_URI']);
        if(in_array($url_result['0'], $route_list)){
            return true;
        }else{
            return true;
        }
    }

    
    public static function getNamebyid($id)
    {
        $user = User::findOne(['id'=>$id]);
        return $user->userdisplay;
    }
    
    public static function findIdentity($id)
    {
        $user = User::findOne(['id'=>$id,'status'=>0]);
        return is_object($user) ? $user : null;
    }
    /**
     * Finds user by username
     *
     * @param string     $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $userc = User::find(['username'=>$username,'status'=>0])->count();
        Yii::error("user count is : ".$userc);
        if ($userc >= 1){
            return User::findOne(['username'=>$username,'status'=>0]);
        }
        return null;
    }
    
    
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert) {
                if ($this->scenario=="agent"){//Agent号创建
                    $this->role=self::ROLE_AGENT;
                }
                if ($this->isNewRecord){
                    Yii::error(" user is new user ....");
                    $this->password_hash = md5($this->password_hash);
                    $this->auth_key = $this->username;
                    $this->created_at = time();
                }else {
                    if ($this->newpasswd !=""){
                        $this->password_hash = md5($this->newpasswd);
                    }else {
                        $this->password_hash = $this->password_hash;
                    }
                    Yii::error("newpasswd is  ".$this->newpasswd);
                }
                $this->updated_at = time();
                $this->status=0;
            }
            return true;
        } else {
            return false;
        }
    }
    
    
    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        Yii::error("login check passwd :".$this->password_hash.' md5 passwd: '.md5($password));
        return $this->password_hash === md5($password);
    }
    public static function fetchAllManagerUser()
    {
        $ar = User::find()->where('status=0 and role<5')->all();
        return $ar;
    }
    public static function getOpsUserList(){
        $us=ArrayHelper::map(User::fetchAllManagerUser(), 'id', 'userdisplay');
        $aaaa=$us;
//         Yii::error(' aaaaa: '.print_r($aaaa));
        return $aaaa;
    }

}
