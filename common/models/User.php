<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $nickname
 * @property string $email
 * @property integer $gender
 * @property string $phone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $profile
 * @property string $head_picture
 * @property string $create_time
 * @property string $modify_time
 * @property string $active_time
 * @property string $status
 * @property string $auth_key
 * @property string $role_id
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 'delete';//删除用户状态
    const STATUS_ACTIVE = 'active';//活动(正常)用户状态
    const STATUS_LOCK = 'lock';//锁定用户状态
    const GENDER_DEFAULT = 1;//默认性别

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                ['gender', 'phone', 'create_time', 'modify_time', 'active_time', 'role_id'],
                'integer',
                'on' => ['sign','login','modify'],
                'message'=>'{attribute}必须为纯数字'
            ],
            [
                ['username', 'nickname'],
                'string',
                'min'=>2,
                'max' => 45,
                'on' => ['sign','login','modify'],
                'message'=>'{attribute}在2~16个字符之间'
            ],
            [
                ['email', 'password_hash', 'profile'],
                'string',
                'max' => 255,
                'on' => ['sign','login','modify'],
                'message' => '{attribute}最多255个字符'
            ],
            [
                ['head_picture', 'auth_key', 'password_reset_token'],
                'string',
                'max' => 100,
                'on' => ['sign','login','modify'],
                'message' => '{attribute}最多100个字符'
            ],
            [
                ['username','nickname','email','phone'],
                'unique',
                'on' => ['sign','modify'],
                'message' => '{attribute}已经被使用了'
            ],
            [
                ['create_time','modify_time','active_time','status','role_id','password_hash','username','nickname','auth_key','password_reset_token','gender'],
                'required',
                'on' => ['sign'],
                'message' => '{attribute}不能为空'
            ],
            [
                ['username','nickname','email'],
                'unique',
                'message' => '这个{attribute}已经被使用了'
            ],
            [
                'role_id', 'validateRole','message'=>'{attribute}错误','on' => ['sign']
            ],
            [
                'status', 'default', 'value' => self::STATUS_ACTIVE,'on' => ['sign']
            ],
            [
                'status', 'in',
                'range' => [
                    self::STATUS_ACTIVE,
                    self::STATUS_DELETED,
                    self::STATUS_LOCK
                ],
                'message' => '{attribute}非法',
                'on' => ['sign']
            ],
        ];
    }

    /**
     * Validates the role.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateRole($attribute, $params)
    {
        //以下代码仅供参考
//        if (!$this->hasErrors()) {
//            $user = $this->getUser();
//            if (!$user || !$user->validatePassword($this->password)) {
//                $this->addError($attribute, 'Incorrect username or password.');
//            }
//        }
        //TODO: 等角色表完成再写这儿
    }

    public function scenarios(){
        return [
            'sign' => [
                'email',
                'username',
                'nickname',
                'create_time',
                'modify_time',
                'active_time',
                'password_hash',
                'password_reset_token',
                'status',
                'auth_key',
                'gender'
            ],
            'login' => [
                'username',
                'active_time'
            ],
            'modify' => [
                'modify_time'
            ],
            'reset_password' => [
                'password_reset_token'
            ]
        ];
    }

//    public function beforeSave(){
//    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'nickname' => '昵称',
            'email' => '邮箱',
            'gender' => '性别',
            'phone' => '手机号',
            'password_hash' => '密码HASH值',
            'profile' => '个人简介',
            'head_picture' => '头像',
            'create_time' => '注册时间',
            'modify_time' => '修改时间',
            'active_time' => '上次活动时间',
            'status' => '状态',
            'auth_key' => '密钥',
            'password_reset_token' => '重置密码密钥',
            'role_id' => '角色ID',
        ];
    }

/**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
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
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
