<?php

namespace Home\Model;
use Think\Model;

class BooksModel extends Model{
    public $book_id;
    public $book_name;
    public $class_id;
    public $book_url;
    public $book_author;
    public $book_translator;
    public $book_print;
    public $book_isbn;
    public $book_info;
    public $book_count;
    public $book_price;
    //public $book_seller;
    public $openid;
    public $datetime;

    public function __construct($book_id, $book_name, $class_id, $book_url, $book_author, $book_translator, $book_print,$book_isbn, $book_info, $book_count, $book_price, $openid,$datetime) {
        $this->book_id = $book_id;
        $this->book_name = $book_name;
        $this->class_id = $class_id;
        $this->book_url = $book_url;
        $this->book_author = $book_author;
        $this->book_translator = $book_translator;
        $this->book_print = $book_print;
        $this->book_isbn = $book_isbn;
        $this->book_info = $book_info;
        $this->book_count = $book_count;
        $this->book_price = $book_price;
        //$this->book_seller = $book_seller;
        $this->openid = $openid;
        $this->datetime = $datetime;
    }
    public function getId() {
        return $this->book_id;
    }
    public function getName() {
        return $this->book_name;
    }
    public function getClassId() {
        return $this->class_id;
    }
    public function getUrl() {
        return $this->book_url;
    }   
    public function getAuthor() {
        return $this->book_author;   
    } 
    public function getTranslator(){
        return $this->book_translator;
    }
    public function getPrint() {
        return $this->book_print;   
    }  
    public function getISBN() {
        return $this->book_isbn;   
    }  
    public function getInfo() {
        return $this->book_info;   
    } 
    public function getCount(){
        return $this->book_count;
    }
    public function getPrice(){
        return $this->book_price;
    }
    public function getOpenid(){
        return $this->openid;
    }
    public function getDatetime(){
        return $this->datetime;
    }
    
    public function insertBookInfo($book_name,$class_id,$book_url,$book_author,$book_translator,$book_print,$book_isbn,$book_info,$book_count,$book_price,$openid){
    	$book = M('books');
    	$data['book_id'] = '';
    	$data['book_name'] = $book_name;
    	$data['class_id'] = $class_id;
    	$data['book_url'] = $book_url;
    	$data['book_author'] = $book_author;
    	$data['book_translator'] = $book_translator;
    	$data['book_print'] = $book_print;
    	$data['book_isbn'] = $book_isbn;
    	$data['book_info'] = $book_info;
        $data['book_count'] = $book_count;
        $data['book_price'] = $book_price;
        //$data['book_seller'] = $book_seller;
        $data['openid'] = $openid;
        $date['datetime'] = '';
        $book->add($data);
    }
    
    public function insertOpenid($openid){
        $book = M('books');
        $data['book_id'] = '';
        $data['book_name'] = '';
        $data['class_id'] = '';
        $data['book_url'] = '';
        $data['book_author'] = '';
        $data['book_translator'] = '';
        $data['book_print'] = '';
        $data['book_isbn'] = '';
        $data['book_info'] = '';
        $data['book_count'] = '';
        $data['book_price'] = '';
        $data['openid'] = $openid;
        $date['datetime'] = '';
        $book->add($data);
    }
    
    public static function selectByISBN($book_isbn){
    	$book = M('books');
    	$condition['book_isbn'] = $book_isbn;
    	$answer = $book->where($condition)->select();
    	return $answer;
    }
    
    public static function selectByOpenid($openid){
    	$book = M('books');
    	$condition['openid'] = $openid;
    	$answer = $book->where($condition)->select();
    	return $answer;
    }
    
    public static function selectById($book_id){
        $book = M('books');
        $condition['book_id'] = $book_id;
        $answer = $book->where($condition)->select();
        return $answer;
    }
      
    public static function findBooks($book_isbn,$openid){
        $book = M('books');
        $condition['book_isbn'] = $book_isbn;
        $condition['openid'] = $openid;
        $answer = $book->where($condition)->select();
        return $answer;
    }
    
    public static function findAll(){
        $book = M('books');
        $answer = $book->select();
        return $answer;
    }
    
    public static function findBookLike($book_name){
        $book = M('books');
        $map['book_name'] = array('like',"%$book_name%");
        $answer = $book->where($map)->select();
        return $answer;
    }
    
    public static function findBookCount($book_name){
        $book = M('books');
        $map['book_name'] = array('like',"%$book_name%");
        $answer = $book->where($map)->count();
        return $answer;
    }
    
    public function deleteById($book_id){
        $book = M('books');
        $condition['book_id'] = $book_id;
        $result = $book->where($condition)->delete();
    }
    
    public function minusBook($book_id){
        $book = M('books');
        $condition['book_id'] = $book_id;
        $book->where($condition)->setDec('book_count');
    }
    
    public static function selectByClassid($class_id){
        $book = M('books');
        $condition['class_id'] = $class_id;
        $answer = $book->where($condition)->select();
        return $answer;
    }
    
    public static function selectDateTime($starttime,$endtime,$openid){
        $book = M('books');
        $map['datetime'] = array('between',"$starttime,$endtime");
        $map['openid'] = $openid;
        $answer = $book->where($map)->select();
        return $answer;
    }
}
?>