<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $re_password;//确认密码
    public $create_time;
    public $modify_time;
    public $active_time;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','email'], 'filter', 'filter' => 'trim'],
            [['username','email','password'], 'required','message'=>'{attribute}不能为空'],
            [['username','email'], 'unique', 'targetClass' => '\common\models\User', 'message' => '这个{attribute}已经被使用了'],
            ['username', 'string', 'min' => 2, 'max' => 16,'message'=>'{attribute}在6~16位之间'],
            [['create_time','modify_time','active_time'],'default','value'=>time()],
            ['email', 'email','message'=>'{attribute}格式错误'],
            [['password','re_password'], 'string', 'min' => 6,'max'=>18 ,'message'=>'{attribute}必须在6~18位之间'],
            ['re_password','compare','compareAttribute'=>'password','message'=>'两次密码不一致'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'email' => '邮箱',
            'password' => '密码',
            're_password' =>'确认密码'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->scenario = 'sign';
            $user->attributes = $this->getAttributes();
            $user->nickname = $this->username;
            $user->setPassword($this->password);
            $user->generatePasswordResetToken();
            $user->generateAuthKey();
            $user->status = $user::STATUS_ACTIVE;
            $user->gender = $user::GENDER_DEFAULT;
            $user->save();
            return $user;
        }

        return null;
    }
}
