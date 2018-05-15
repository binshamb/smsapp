<?php
include 'lib/helper.php';
include 'config.php';
	Class sms {
		function __construct() 
    	{     
	            
    	}

    	public function messageSend($params)
    	{
             $helperObj = new helper();
            if(!isset($params['reply_to'])){
                $data = ['code'=>"reply_to is not set"];
                if(!isset($params['recipient']))
                    $params['recipient'] ='';
                $result = $helperObj->convertToXml($data,$params['recipient']);
                return $result;
            } else if(!isset($params['recipient'])){
                $data = ['code'=>"recipient is not set"]; 
                $result = $helperObj->convertToXml($data,'');
                return $result;
            } else if(!isset($params['body'])){
                $data = ['code'=>"body is not set"]; 
                 if(!isset($params['recipient']))
                    $params['recipient'] ='';
                $result = $helperObj->convertToXml($data,$params['recipient']);
                return $result;                
            }
            $preparedData  = array(
                                    "from"  =>  $params['reply_to'],
                                    "to"    =>  array($params['recipient']),
                                    "body"=> $params['body']
                                    );
            $postData       = json_encode($preparedData);
            $url            = "https://api.clxcommunications.com/xms/v1/".SERVICE_PLAN_ID."/batches";
            $httpheader     = ['content-type: application/json','authorization: Bearer '.AUTH_TOKEN.''];
            $result =  $helperObj->runcurl($url,$postData,$httpheader);
            $result     = json_decode($result,true);
            $result = $helperObj->convertToXml($result,$preparedData['to'] );
            return $result;
    	}
        public function requestInBound(){

            $url            = "https://api.clxcommunications.com/xms/v1/".SERVICE_PLAN_ID."/inbounds";
            $httpheader     = ['authorization: Bearer '.AUTH_TOKEN.''];
            $curlObj = new curlrequest();
            $result =  $curlObj->runcurl($url,null,$httpheader);
            return $result;
        }
       	
	}
?>