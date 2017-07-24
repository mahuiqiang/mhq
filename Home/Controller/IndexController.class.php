<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	//查询首页的所有栏目
    	 $lanmu = D('Admin/Cat')->getree();
    	 $this->assign('lanmu',$lanmu);
    	// field 查询的字段  $hot_goods 查询排名前4的hot_goods
    	$hot_goods = D('Goods')->field('goods_id,goods_name,shop_price,thumb_img,market_price')->where('is_hot=1')->order('goods_id desc')->limit(4)->select();
    	$this->assign('hots',$hot_goods);
        $this->display();    
    }
}