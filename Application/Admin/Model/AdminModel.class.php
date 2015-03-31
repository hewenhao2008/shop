<?php
namespace Admin\Model;
use Think\Model;
class AdminModel extends Model {
	protected $_validate = array(
	    array('username','require','用户名不能为空',1),
	    array('password','require','密码不能为空',1),
	    array('chk_code','require','验证码不能为空',1,'regex',4),
	    array('chk_code','chk_verify','验证码不正确',1,'callback',4),
	    array('username','','用户名已经存在',1,'unique',1),
	    array('username','','用户名已经存在',1,'unique',2),
	    array('password','rpassword','两次密码不一致',1,'confirm',1),
	    array('password','rpassword','两次密码不一致',1,'confirm',2),
	);
	
	// 检测输入的验证码是否正确，$code为用户输入的验证码字符串
    function chk_verify($code){
		$verify = new \Think\Verify();
		return $verify->check($code);
    }
    //列表逻辑
    public function search() {
		$count = $this -> count();// 查询满足要求的总记录数
		$Page = new \Think\Page($count,3);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show = $Page -> show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $this -> limit($Page->firstRow.','.$Page->listRows) -> select();
		return array('list' => $list,'show' => $show);
		}
	public function login() {
		//取得用户提交的密码
		$passwd = $this -> password ;
		$passwd = strtolower($passwd);
		$info = $this -> where("username='{$this -> username}'") -> find();
		//如果用户名存在
		if($info) {
			//如果数据库中的密码与提交相同 成功
			if($info['password'] == md5(md5($passwd) . $info['salt'])){
			        session('id',$info['id']);
			        session('username',$info['username']);
			        if($_POST['remember']) {
			            cookie('rem','sojisub',3600);
					}
			        return TRUE;
			}else
			    return 2;
		}else
			return 1;
	}
	public function logout() {
	    session(null);	
	}
	public function _before_insert(&$data,$option) {
		$data ['salt'] = substr(uniqid(),-6); 
		$data ['password'] = md5(md5($_POST['password']) . $data['salt']);
	}
}
