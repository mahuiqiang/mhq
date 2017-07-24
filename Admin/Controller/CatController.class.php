<?php
namespace Admin\Controller;
use Think\Controller;
class CatController extends Controller {
	//添加
    public function cateadd(){
        //如果没有post数据就引入模板,如有数据,则new
        if (!IS_POST) {
            $this->display();
            exit();
            }else{      
                    //连接cat表
                    $catModel = D('Cat');
                    if (!$catModel->create()) {
                        echo $catModel->getError();
                        exit();
                    }else{


                    //如果栏目表添加成功,在往attr表中添加相应的数据
                    if ($cat_id = $catModel->add($_POST)) {
                        //连接attr表
                        $model = D('attr');
                        $info = array();
                        //尺寸
                        $value_size = implode(',', $_POST['attr_value']);
                        //颜色
                        $value_color = implode(',', $_POST['attr_value1']);
                        //
                        $attr_name = $_POST['attr_name'];
                        $attr_key = $_POST['attr_key'];
                        $attr_name1 = $_POST['attr_name1'];
                        $attr_key1 = $_POST['attr_key1'];

                        //整理信息 尺寸
                        $info[] =  array('cat_id'=>$cat_id,'attr_value'=>$value_size,'attr_name'=>$attr_name,'attr_key'=>$attr_key);
                        //整理信息 颜色 
                        $info[] =  array('cat_id'=>$cat_id,'attr_value'=>$value_color,'attr_name'=>$attr_name1,'attr_key'=>$attr_key1);

                        $model->addAll($info);

                    }
                //print_r($_POST);
            	//$catModel = D('Cat');   //new Admin/Model/Cat  Model是父类CatModel是子类
            	// $catModel ->add($_POST);   //添加从POST中获得的数组
                //$catModel->add(I('post.')) ;
            } 
         }
         $this->redirect('Admin/Cat/catelist'); 
    }
    //栏目列表
    public function catelist(){
    	$catModel = D('Cat');
        //快速缓存F() 和S一样.不设时间的话,相等于手动删除之前,永久有效 
        $cat = S('list');
        if ($cat == false) {
              // $catelist =$catModel->select();//查询数据库cat表
            // var_dump($catelist);exit();查出的是二维数组
            echo "这是从数据库中出来的呃!";
            $list = $catModel->getree();
            S('list',$list,5);  
        }else{
            echo "缓存的数据!";
            $list = $cat;
        }
    	
    	$this->assign('list',$list) ;//给摸版传值  二维数组
        $this->display();    
    }
    //栏目删除
    public function catedel(){
    	$catModel = D('Cat');
    	$cat_id = I('cat_id'); //获取cat_id值
    	$catModel ->delete($cat_id);
    	$this->success('删除成功!','','5');//成功方法 几秒后跳转  第二个参数如果不写则跳转到之前的页面
    	//$this->error('删除失败!');默认返回上一页

    }
    //栏目编辑
    public function catedit(){
    	$catModel = D('Cat');  
    	//没有post
    	if (!IS_POST) {
    		$cat_id = I('cat_id');
    		$catinfo = $catModel->find($cat_id);
    		$this->assign('info',$catinfo);
    		$this->display();
    	}else{ //有post 要修改了 
    		$catModel->where('cat_id='.$_POST['cat_id'])->save($_POST);
    		//修改的$_POST数组
    	}
    }
  
}