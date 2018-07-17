<?php

namespace Home\Controller;
use Think\Controller;
use Home\Model\UserModel;

class TestController extends Controller{
    public function index()
    { 
        $code = $_GET["code"];
        $result = self::getUserInfo($code);
        $user = new UserModel();
        $answer = $user->selectByOpenid($result['openid']);
        if(empty($answer)){ 
            $user->insertUser($result['openid'],$result['nickname'],$result['sex']);
        }
        /*else{  //可能存在延迟，所以两个用户名相等……
            //$condition['user_nickname'] = $result['nickname'];
            //$answer = $user->where($condition)->select();
            $answer1 = $user->selectByNickname($result['nickname']);
            //var_dump($answer1[0]['user_nickname']);die;
            var_dump($answer1[0]['user_nickname']);var_dump($result['nickname']);die;
            if($answer1[0]['user_nickname'] != $result['nickname']){
                $data2['user_nickname'] = $result['nickname'];
                $user->where($answer[0]['openid'] = $result['openid'])->save($data2);
            }
        }*/
        
        //$_SESSION['openid'] = $result['openid'];
        //var_dump($result['openid']);
        //cookie('openid',$result['openid'],3600);
        //$value = cookie('openid');
        //var_dump($value);die;
        //$value=session();
        //var_dump($_SESSION['openid']);die;
        $this->assign($result);
        $this->display("index");  
    }
   
	public static function getUserInfo($code)
	{
    $appid = "wxccdc7d0ff61299f6";
	$appsecret = "9cfe8bda6e88df570c58b0c2c253b09f";

	if(empty($_COOKIE['openid'])){
		$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
		$result = json_decode(file_get_contents($url),true);
		if(empty($result['access_token'])){
            //echo '微信授权失败，access_token获取失败';
            exit;
		}

		$token = $result['access_token'];
		$openid = $result['openid'];
		$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$token."&openid=".$openid."&lang=zh_CN";
		$result = json_decode(file_get_contents($url),true);

		if(empty($result['openid'])){
            //echo '微信授权失败，openid获取失败';
            exit;
		}
	}
        return $result;
    }
}
?>