<?php

namespace Home\Model;
use Think\Model;

class UserModel extends Model{
	public $user_id;
	public $openid;
	public $user_nickname;
    public $user_connect;
	public $user_mail;
	public $user_department;
	public $user_sex;

	public function __construct($user_id, $openid, $user_nickname, $user_connect, $user_mail, $user_department, $user_sex){
		$this->user_id = $user_id;
		$this->openid = $openid;
		$this->user_nickname = $user_nickname;
        $this->user_connect = $user_connect;
		$this->user_mail = $user_mail;
		$this->user_department = $user_department;
		$this->user_sex = $user_sex;
	}

    public function getUserId(){
    	return $this->user_id;
    }
    public function getOpenid(){
    	return $this->openid;
    }
    public function getNickname(){
    	return $this->user_nickname;
    }
    public function getConnect(){
        return $this->user_connect;
    }
    public function getMail(){
    	return $this->user_mail;
    }
    public function getDepartment(){
    	return $this->user_department;
    }
    public function getSex(){
    	return $this->user_sex;
    }

    public function insertUser($openid,$user_nickname,$sex){
    	$user = M('user');
    	$data['user_id']='';
        $data['openid']=$openid;
        $data['user_nickname']=$user_nickname;
        $data['user_connect'] = '';
        $data['user_mail']='';
        $data['user_department']='';
        $data['user_sex']=$sex;
        $user->add($data);
    }

    public static function selectByOpenid($openid){
    	$user = M('user');
    	$condition['openid'] = $openid;
    	$answer = $user->where($condition)->select();
    	return $answer;
    }
    
    public static function selectByNickname($nickname){
    	$user = M('user');
    	$condition['user_nickname'] = $nickname;
    	$answer = $user->where($condition)->select();
    	return $answer;
    }
    
    public function insertMore($openid,$user_connect,$user_mail,$user_department){
        $user = M('user');
        $condition['openid'] = $openid;
        $data = array('user_connect'=>$user_connect,'user_mail'=>$user_mail,'user_department'=>$user_department);
        $user->where($condition)->setField($data);
    }
    
    
}
?>