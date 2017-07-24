<?php
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends Controller {
	    public function goodsadd(){
	        // $this->display(); 
	        if (!IS_POST) {
	        	$this->display();
	        }else{
	        	$GoodsModel = D('Goods');
	        	$upload = new \Think\Upload();//上传类对象
	        	$upload->exts = array('jpg','gif','png','jpeg');//设置上传的类型
	        	$upload ->maxSize = 8*1024*1024;//设置上传的大小
	        	$upload ->rootPath = './Public/upload/';//设置文件上传的跟目录
	        	$info = $upload->upload();//上传 返回的是一个二维数组

	        	if (!$info) {
	        		var_dump($upload->getError()); //得到错物信息
	        		exit();
	        	}else{
	        		echo "<pre>";//格式化输出数据
	        		var_dump($info);
	        		//图片存入数据库的路径,不带点
	        		$_POST['goods_img'] = '/Public/upload/'.$info['goods_img']['savepath'].$info['goods_img']['savename'];
	        		$img = new \Think\Image();//new 图片处理类的对象
	        		$path = './Public/upload/'.$info['goods_img']['savepath'].$info['goods_img']['savename'];//小图片的原图存放地址
	        		$img -> open($path);//打开它!
	        		//缩略图保存的地址
	        		$thumb_path = './Public/thumb/'.$info['goods_img']['savename'];
	        		//缩略图保存到数据库的地址,不带点的
	        	$thumb_path1 = '/Public/thumb/'.$info['goods_img']['savename'];
	        	$img->thumb(100,100)->save($thumb_path);//生成缩略图
	        	$_POST['thumb_img'] = $thumb_path1;//赋值thumb_img



	        	}	

	        	// exit();
	        	if (!$GoodsModel->create()) {//批量赋值
	        		echo $GoodsModel->getError();//
	        		exit();
	        	}else{
	        		if ($goods_id = $GoodsModel->add()) {
	        			 $model = M('goods_attr');
                    $model->goods_id = $goods_id;
                    $model->attr_key = $_POST['size'];
                    $model->attr_value = $_POST['color'];
                    $model->add();
	        		}
	        		// echo "成功!";
	        		//$GoodsModel->add();//默认全部
	        	}
			}
	    }


	    
	    //商品列表
	    public function goodslist(){
	    	//查询商品
	    	$model = new \Home\Model\GoodsModel();//实例化
	    	$count = $model->count();//查数据库中的数据数量
	    	$page = new \Think\Page($count,10);//规定每页10条数据
	    	$show = $page->show();//这时出来的页码数

	    	//按照字段查询
	    	$goods = $model->field('goods_id,goods_name,goods_sn,shop_price,is_on_sale,is_best,is_new,is_hot,goods_number')->order('goods_id')->limit($page->firstRow.','.$page->listRows)->select(); 
	    	$this->assign('page',$show);//页码数
	    	$this->assign('goods',$goods);
	        $this->display();    
	    }
	    //商品删除
	    public function goodsdel(){
	    	$model = D('Goods');
	    	$res = $model->delete(I('get.goods_id'));//返回影响的行数
	    	if ($res) {
	    		$this->redirect('Admin/Goods/goodslist');
	    	}else{
	    		echo "删除失败!";
	    	}
	    }
   		public function goodsedit(){
   			$model = D('Goods');
   			$goods_id = I('goods_id');
   			if (!IS_POST) {
   				$res = $model->find($goods_id);
   				$this->assign('res',$res);
   				$this->display();
   			}else{
   				echo $goods_id;
   				$model->where('goods_id = '.$goods_id)->save($_POST);
   			}

   		}
  
}