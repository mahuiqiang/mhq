<?php
namespace Home\Controller;
use Think\Controller;
class GoodsController extends Controller {
    public function goods(){
        $goods = D('Goods');
    	//获取goods_id
    	$goods_id = I('get.goods_id');
    	//查询good信息
    	$good = $goods->find($goods_id);
        //得到评论
        $goods_comment = $goods->relationGet('comment');
        //var_dump($goods_comment);
        $this->assign('goods_c',$goods_comment);


        //调用history($good)生成历史
        if ($good) {
            $this->history($good);
        }
        
    	//调用面包屑,并赋值商品的cat_id
    	$mbx = $this->mbx($good['cat_id']);
    	//导入模板
    	$this->assign('mbx',$mbx);
    	$this->assign('goods',$good);
        $this->display();    
    }

        //历史浏览,供goods使用,参数是查到的good信息
        public function history($info){
            //判断有无session
            $row = session('?history')?session('history'):array();
            $g = array();
            //数据太杂,只要这3个数据
            $g['goods_id'] = $info['goods_id'] ;
            $g['goods_name'] = $info['goods_name'] ;
            $g['shop_price'] = $info['shop_price'] ;
            //把$g赋给$row 键是info中的goods_id
            $row[$info['goods_id']] = $g;

            if(count($row)>5){
                $key = key($row);//第一个键名
                unset($row[$key]);//删除第一个元素
            }

            session('history',$row);
        }




    public function mbx($cat_id){
    	//在cat表里面查询
    	$row = D('Cat')->find($cat_id);
    	//放在二维数组中
    	$tree[] = $row; 
    	//判断parent_id是否大于零 如果大于零 则取这一行数据
     	while ($row['parent'] >0) {
    		$row = D('Cat')->find($row['parent']);
    		$tree[] = $row;
    	}
    	return array_reverse($tree);
    }
//评论添加
    public function addcomment(){
        // var_dump($_POST);
        if (D('comment')->add($_POST)) {
            $this->success('添加成功!');
        }
    }
}