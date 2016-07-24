<?php

namespace app\models;
use Yii;
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password;
	public $retype_password;

public static function tableName()
    {
        return 'user';
    }

public function rules()
    {
        return [
            // username and password are both required
            [['email'], 'required'],
	 [['email'],'unique'],
        [['email','auth_key','password_hash','access_token','password','retype_password'], 'safe']];
    }

    /**
     * @inheritdoc
     
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }
	*/
    /**
     * @inheritdoc
     
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }
	*/
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }*/

    /**
     * @inheritdoc
     
    public function getId()
    {
        return $this->id;
    }*/

    /**
     * @inheritdoc
     
    public function getAuthKey()
    {
        return $this->authKey;
    }
	*/
    /**
     * @inheritdoc
     
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }
	*/
    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
	*/
	public function getAuthKey() {
        return $this->auth_key;
    }
public function setAuthKey() {
        return $this->auth_key= rand(1,9999999);
    }
    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
       return $this->auth_key = $authKey;
    }

    public static function findIdentity($id) {

        return self::findOne($id);

    }

    public static function findIdentityByAccessToken($token, $type = null) {

        return $this->access_token;
    }

    public static function findByUsername($email){
        return self::findOne(['email'=>$email]);
    }

    public function validatePassword($password){
return Yii::$app->getSecurity()->validatePassword($password, $this->password_hash);
    }
	public function generatePasswordHash($password){
$this->password_hash = \Yii::$app->security->generatePasswordHash($password);
}
}
