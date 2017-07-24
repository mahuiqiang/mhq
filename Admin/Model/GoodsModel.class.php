<?php  
namespace Admin\Model;
use Think\Model;
class GoodsModel extends Model{
	//自动验证 array(验证字段,验证规则,失败提示信息,验证条件,附加规则,验证时间)静态
	protected $_validate  = array(
		array('goods_name','3,10','商品名字的长度在3和10之间',1,'length',3),
		array('goods_sn','','商品货号已有!',1,'unique',3)
		);
	protected $_auto = array(
		//array(完成字段1,完成规则,[完成条件,附加规则]),
		array('add_time','time',1,'function'),
		array('last_update','time',2,'function')
		);
	//自动过滤  :允许添加的字段
	protected $insertfieds = 'goods_id,cat_id,goods_name,goods_number,goods_weight,shop_price,goods_desc,goods_brief,ori_img,goods_img,thumb_img,is_best,is_new,is_hot,is_no_sale';

}