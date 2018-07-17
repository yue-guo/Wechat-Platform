<?php
namespace Home\Controller;
use Think\Controller;

class IndexController extends Controller {
    public function index(){
        //$result = M('user')->select();
        //var_dump($result);die;
        //echo "123";
        $this->display('index');
    }
}