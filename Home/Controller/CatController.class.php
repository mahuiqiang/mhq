<?php
namespace Home\Controller;
use Think\Controller;
class CatController extends Controller {
    public function cat(){
        //跨模块调用
        $lanmu = D('Admin/Cat')->getree();
         $this->assign('lanmu',$lanmu);
        if (I('get.cat_id')) {
                  //获取cat_id
                $cat_id = I('get.cat_id');

                $this->assign('his',array_reverse(session('history')));
                // print_r(session('history'));
                //查询此栏目下的goods
                $goods = D('Goods')->field('goods_id,goods_name,shop_price,market_price,thumb_img')->where("cat_id=$cat_id")->select();
                
                $this->assign('goods',$goods);
                $this->display();  
        }elseif(I('get.keywords')){
                $keywords = I('get.keywords');
                $goodsmodel = M('Goods');
                //模糊查询
                $con['goods_name'] = array('like',"%{$keywords}%"); 
                $cats = $goodsmodel->where($con)->select();
                $this->assign('goods',$cats);
                $this->display();
        }
    	
    	


    	    
        
    }
       
  
}