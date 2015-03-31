<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function login(){
		if(IS_POST){
			//生成模型对象
			$model = D('Admin');
			//收集表单数据并处理
			if($model -> create($_POST,4)){
			  $result = $model -> login();
			  //登陆成功，返回TRUE，返回1 ,用户名不存在，其他 密码错误
			  if($result === TRUE) {
				  $this -> success("登陆成功！",U('Index/index'));
				  exit;
			  }else
				  $error = $result == 1 ? '用户名不存在！' : '密码错误！'; 
				  $this -> error($error);
			  
			}else
			  $this -> error($model -> getError());
		}
		$this -> display(); 
	}
    //生成验证码
    public function chkCodeImg() {
		$Verify = new \Think\Verify(array('length'    =>  2));
		$Verify->entry();
	}
	//退出
	public function logout() {
		$model = D('Admin');
		$model -> logout();
		redirect('login');
	}
}

