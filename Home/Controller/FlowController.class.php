<?php 
namespace Home\Controller;
use Think\Controller;
class FlowController extends Controller {
	//购物车添加
    public function add(){
    	//实例化Goods对象
    	$goods = D('Goods');
    	//如果没有在goods表中查到,则返回首页面
    		if (!$goodsinfo = $goods->find(I('get.goods_id'))) {
    			$this->redirect('/');
    			exit();
    		}
    		//在goods表中查到了商品信息,则实例化购物车类
    		$car =  \Home\Tool\CartTool::getIns();
    		//加多少都白搭,因为脚本运行到初次结束了,下次还得继续从头执行,而且可以多次new
    		$car->add($goodsinfo['goods_id'],$goodsinfo['goods_name'],$goodsinfo['shop_price']);
    		 // var_dump($car->items());
    	   $this->assign('che',$car->items());//返回  $item
    	  $this->display('Flow/checkout');
    	  // $this->checkout();
    }

    public function done(){
    	//实例化cart
    	$car = \Home\Tool\CartTool::getIns();
    	//实例化对象  ordinfo订单信息表
    	$oi = M('ordinfo');
    	$oi->create();//接受post表单数据
    	$oi->ord_sn = $ord_sn = date('Ymd').mt_rand(1000,9999);
    	//在cookie中获得user_id
    	$oi->user_id = cookie('user_id')?cookie('user_id'):0;
    	//调用方法获得总钱数
    	$oi->money = $car->calcMoney();
    	$oi->ordtime = time();

    	if ($ordinfo_id = $oi->add()) {
    		$og = M('ordgoods');
    		$data = array();

    			foreach ($car->items() as $k => $v) {
    			 	$row = array();
    			 	$row['goods_id'] = $k;
    			 	$row['goods_name'] = $v['goods_name'];
    			 	$row['shop_price'] = $v['shop_price'];
    			 	$row['goods_num'] = $v['num'];
    			 	$row['ordinfo_id'] = $ordinfo_id;
    			 	$data[] = $row;
    			 } 
    			 if ($og->addAll($data)) {
    			 		$this->assign('ord_sn',$ord_sn);
    			 		$this->assign('money',$car->calcMoney());
    			 }
    	}
    	$this->display();

    }

    // public function checkout(){
    // 	$this->assign('che',$car->items());
    // 	$this->display();
    // }

    public function pay(){

    	//利用银行的标准
    	$row = array();
    	$row['v_amount'] = 0.01;
    	$row['v_moneytype'] = 'CNY';
    	$row['v_oid'] = date('Ymd').mt_rand('1000,9999');
    	$row['v_mid'] = '1009001';
    	$row['v_url'] = 'http://127.0.0.1/2.php';
    	$row['key'] = '#(%#WU)(UFGDKJGNDFG';
    	//生成MD5
    	$row['v_md5info'] = strtoupper(md5($row['v_amount'].$row['v_moneytype'].$row['v_oid'].$row['v_mid'].$row['v_url'].$row['key']));
       $this->assign('pay',$row);
       $this->display();

    }
}