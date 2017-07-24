<?php  
namespace Home\Model;
use Think\Model\RelationModel;
//继承关联模型
class GoodsModel extends RelationModel{
	protected $_link = array(
//声明关联关系
//
		'comment' => self::HAS_MANY  //此处是一个静态的本类,继承过来以后self
		);
	
}
