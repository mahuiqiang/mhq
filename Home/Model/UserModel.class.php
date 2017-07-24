<?php  
namespace Home\Model;
use Think\Model;
class UserModel extends Model{
	//自动验证
	protected $_validate = array(
			array('username','8,30','用户名长度8到10位',1,'length',3),
			array('email','email','邮箱不合法',1,'regex',3),
			array('password','6,32','密码长度必须6到32位',1,'length',3),
			array('confirm_password','password','两次密码不一致',1,'confirm',3)

		); 	




}