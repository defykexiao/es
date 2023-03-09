<?php
namespace app\index\controller;
use think\Controller;
use app\common\model\Stream;
use app\common\model\User;
class HomepageController extends Controller{
    public function index(){
       $Stream =new Stream;
       $income = $Stream->where('inandex','=','1')->sum('money');//收入
       $pay = $Stream->where('inandex','=','0')->sum('money');//支出
       $sum =  $income - $pay;

       if(User::isLogin()){

            $id = session('userId');//判断用户权限，用户则输出“系统管理”菜单，用户则相反,请勿删除换行
            $User = User::get($id);
            session('perId',$User->getData('permissions'));
           
            $perId = session('perId');
        
            $this->assign('perId',$perId);
            $this->assign('sum',$sum);
            return $this->fetch();       
       }
       else{
            return $this->error('请登录后在访问',url('login_controller/index'));
       }

      
    }
}