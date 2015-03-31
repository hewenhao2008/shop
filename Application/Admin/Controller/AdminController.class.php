<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
    public function __construct() {
		parent :: __construct();
		if(!cookie("rem") == "sojisub") {
		    //如果sessionid 存在 代表登陆了
			if(!session('id')) {
				$this -> error('您没登陆，请登陆！',U('Admin/Login/login'));
			}
	    }
	}
	//添加
	public function add() {
		if(IS_POST) {
			$model = D('Admin');
			if($model -> create()) {
				 if($model -> add()) {
					 $this -> success('添加成功！',U("lst"));
					 exit;
				  }else
				     $this -> error("添加失败！");
			}else{
				 $this -> error($model->getError());
			}
		}
		$this -> display();
	}
	//修改
	public function save() {
		
	}
	//删除
	public function lst() {
		$model = D('Admin');
		$data = $model -> search();
		$this->assign('list',$data['list']);// 赋值数据集
		$this->assign('show',$data['show']);// 赋值分页输出
		$this->display(); // 输出模板
	}
	//删除
	public function del($id) {
		$model = D("Admin");
		if($id > 1){
			$model -> delete($id);
			$this -> success('删除成功！',U('lst'));
	    }else {
			$this -> error("管理员不能删除！");
		}
	}
	//批量删除
	public function bdel() {
		
	}
}

