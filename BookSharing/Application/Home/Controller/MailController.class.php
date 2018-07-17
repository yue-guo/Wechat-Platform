<?php
namespace Home\Controller;
use Think\Controller;

class MailController extends Controller {
    public function index(){
        //$result = M('user')->select();
        //var_dump($result);die;
        //echo "123";
        $this->display('index');
    }
    
    public function add(){    
            if(SendMail($_POST['mail'],$_POST['title'],$_POST['content']))
                $this->success('发送成功！');
            else
                $this->error('发送失败');
    }
}

?>