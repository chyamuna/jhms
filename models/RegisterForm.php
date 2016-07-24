<?php
namespace app\models;

use Yii;
use yii\base\Model;
class RegisterForm extends Model 
{ 
public $email; 
public $password ; 
public $retype_password;
 public $rememberMe = true;
public function tableName() {
 return 'user';
 }

public function rules() 
{ 
return  [[['email', 'password','retype_password'], 'required'],
	[['password'],'compare','compareAttribute'=>'retype_password'],
 ['rememberMe', 'boolean'],
	];
} 
}
