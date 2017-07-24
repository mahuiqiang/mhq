<?php 
namespace Admin\Model;
use Think\Model;
class CatModel extends Model{
		protected $cats = array();
		public function __construct(){
			parent::__construct();//父类的构造方法
			//查询缓存cache();
			$this->cats =$this->cache(true)->select();  //赋值
		} 
		//无极限分类
		public function getree($parent=0,$kg=0){
			$ree = array();

			foreach ($this->cats  as $c) {
				if ($c['parent_id'] == $parent) {
					$c['kg'] =$kg;
				$ree[] = $c;
				
				$ree = array_merge($ree,$this->getree($c['cat_id'],$kg+1));
			}
		}
		return $ree;
	}









}