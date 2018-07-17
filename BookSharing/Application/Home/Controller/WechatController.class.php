<?php

namespace Home\Controller;
use Think\Controller;
use Home\Model\BooksModel;
use Home\Model\SellModel;
use Home\Model\UserModel;
use Home\Model\LocationModel;


class WechatController extends Controller
{
    public function index()
    {
        define("TOKEN", "weixin");
        //$wechatObj = new self();
        
        if (isset($_GET['echostr'])) {
            $this->valid();
        }else{
            $this->responseMsg();
        }   
     }
    
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }

    public function responseMsg()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

        if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;            
            $result = $this->receiveText($postObj);
            /*$RX_TYPE = trim($postObj->MsgType);

			if($RX_TYPE == "event")
                    $result = $this->receiveEvent($postObj);
            if($RX_TYPE == 'text')
                    $result = $this->receiveText($postObj);
            if($RX_TYPE == "location")
                    $result = $this->receiveLocation($postObj);
            }
            $this->logger("T ".$result);*/
            echo $result;
        }else{
            echo "123";
            exit;
        }
    }
    
    private function receiveText($object){
        $keyword = trim($object->Content);
        /*if(empty($keyword)){*/
        $book = new BooksModel();
        $answer = $book->findBookLike($keyword);
        $answer1 = $book->findBookCount($keyword);
         if(!empty($answer1)){
             if($answer1 == 1){
                 $content = array();
        		 $content[] = array("Title"=>$answer[0]['book_name'],"Description"=>"",
            "PicUrl"=>$answer[0]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/BookDetail/bookDetail/id/".$answer[0]['book_id'].".html");
                 $result = $this->transmitNews($object,$content);
             }
             if($answer1 == 2 ){
                 $content = array();
        		 $content[] = array("Title"=>$answer[0]['book_name'],"Description"=>"",
            "PicUrl"=>$answer[0]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/BookDetail/bookDetail/id/".$answer[0]['book_id'].".html");
            	 $content[] = array("Title"=>$answer[1]['book_name'],"Description"=>"",
            "PicUrl"=>$answer[1]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/BookDetail/bookDetail/id/".$answer[1]['book_id'].".html");
                 $result = $this->transmitNews($object,$content);
             }
             if($answer1 == 3){
        		$content = array();
        		$content[] = array("Title"=>$answer[0]['book_name'],"Description"=>"",
            	"PicUrl"=>$answer[0]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/BookDetail/bookDetail/id/".$answer[0]['book_id'].".html");
        		$content[] = array("Title"=>$answer[1]['book_name'],"Description"=>"",
            	"PicUrl"=>$answer[1]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/BookDetail/bookDetail/id/".$answer[1]['book_id'].".html");
        		$content[] = array("Title"=>$answer[2]['book_name'],"Description"=>"",
            	"PicUrl"=>$answer[2]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/BookDetail/bookDetail/id/".$answer[2]['book_id'].".html");
        		$content[] = array("Title"=>"更多书籍信息","Description"=>"",
            	"PicUrl"=>$answer[2]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/home/index");
        		$result = $this->transmitNews($object,$content);
             }
             if($answer1 == 4){
                 $content = array();
        		 $content[] = array("Title"=>$answer[0]['book_name'],"Description"=>"",
            "PicUrl"=>$answer[0]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/BookDetail/bookDetail/id/".$answer[0]['book_id'].".html");
        		 $content[] = array("Title"=>$answer[1]['book_name'],"Description"=>"",
            "PicUrl"=>$answer[1]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/BookDetail/bookDetail/id/".$answer[1]['book_id'].".html");
        		 $content[] = array("Title"=>$answer[2]['book_name'],"Description"=>"",
            "PicUrl"=>$answer[2]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/BookDetail/bookDetail/id/".$answer[2]['book_id'].".html");
            	 $content[] = array("Title"=>"更多结果","Description"=>"",
            "PicUrl"=>$answer[2]['book_url'],"Url"=>"http://1.xiaoyuanyishu1.applinzi.com/index.php/Home/home/index");
        		 $result = $this->transmitNews($object,$content);
                 
             }
        }
        else{
            $content = "平台里没有相关图书信息";
            $result = $this->transmitText($object,$content);
        }
        return $result;
    }
    
    
    /*    private function receiveEvent($object)
    {
    	$contentStr = "";
    	switch ($object->Event)
    	{
        	case "subscribe":
            	$contentStr = "欢迎关注".(isset($object->EventKey)?("\n场景 ".$object->EventKey):"");
            	break;
        	case "unsubscribe":
            	$contentStr = "取消关注";
            	break;
        	case "LOCATION":
            	$url = "http://api.map.baidu.com/geocoder/v2/?ak=B944e1fce373e33ea4627f95f54f2ef9&location=$object->Latitude,$object->Longitude&output=json&coordtype=gcj02ll";
            	$output = file_get_contents($url);
            	$address = json_decode($output, true);
            	$contentStr = "位置 ".$address["result"]["addressComponent"]["province"]." ".$address["result"]["addressComponent"]["city"]." ".$address["result"]["addressComponent"]["district"]." ".$address["result"]["addressComponent"]["street"];
            	break;
        	default:
            	break;
    	}
    	$resultStr = $this->transmitText($object, $contentStr);
    	return $resultStr;
	}*/


    private function logger($log_content)
    {
        if(isset($_SERVER['HTTP_APPNAME'])){   //SAE
            sae_set_display_errors(false);
            sae_debug($log_content);
            sae_set_display_errors(true);
        }else if($_SERVER['REMOTE_ADDR'] != "127.0.0.1"){ //LOCAL
            $max_size = 10000;
            $log_filename = "log.xml";
            if(file_exists($log_filename) and (abs(filesize($log_filename)) > $max_size)){unlink($log_filename);}
            file_put_contents($log_filename, date('H:i:s')." ".$log_content."\r\n", FILE_APPEND);
        }
    }

    private function transmitNews($object, $arr_item)
    {
        if(!is_array($arr_item))
            return;

        $itemTpl = "    <item>
        <Title><![CDATA[%s]]></Title>
        <Description><![CDATA[%s]]></Description>
        <PicUrl><![CDATA[%s]]></PicUrl>
        <Url><![CDATA[%s]]></Url>
    </item>
";
        $item_str = "";
        foreach ($arr_item as $item)
            $item_str .= sprintf($itemTpl, $item['Title'], $item['Description'], $item['PicUrl'], $item['Url']);

        $newsTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[news]]></MsgType>
<Content><![CDATA[]]></Content>
<ArticleCount>%s</ArticleCount>
<Articles>
$item_str</Articles>
</xml>";

        $result = sprintf($newsTpl, $object->FromUserName, $object->ToUserName, time(), count($arr_item));
        return $result;
    }
    
     private function transmitText($object, $content)
    {
        $textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[%s]]></Content>
</xml>";
        $result = sprintf($textTpl, $object->FromUserName, $object->ToUserName, time(), $content);
        return $result;
    }
    
    
    private function receiveEvent($object)
{
    $contentStr = "";
    switch ($object->Event)
    {
        case "subscribe":
            $contentStr = "欢迎关注";
        $resultStr = $this->transmitText($object, $contentStr);
            break;
        case "unsubscribe":
            $contentStr = "取消关注";
            break;
        case "LOCATION":
            $url = "http://api.map.baidu.com/geocoder/v2/?ak=B944e1fce373e33ea4627f95f54f2ef9&location=$object->Latitude,$object->Longitude&output=json&coordtype=gcj02ll";
            $output = file_get_contents($url);
            $address = json_decode($output, true);
            $contentStr = "位置 ".$address["result"]["addressComponent"]["province"]." ".$address["result"]["addressComponent"]["city"]." ".$address["result"]["addressComponent"]["district"]." ".$address["result"]["addressComponent"]["street"];
            break;
        default:
            break;
    }
    $resultStr = $this->transmitText($object, $contentStr);
    return $resultStr;
}
    
}
?>