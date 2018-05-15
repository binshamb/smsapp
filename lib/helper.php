<?php
	Class helper{
		function __construct() 
    	{     
	            
    	}

    	public function runcurl($url,$postData=null,$httpheader=null)
    	{
    		$handle=curl_init($url);
            curl_setopt($handle, CURLOPT_VERBOSE, true);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            $postData!==null?curl_setopt($handle, CURLOPT_POSTFIELDS,$postData):null;
            $httpheader!==null?curl_setopt($handle, CURLOPT_HTTPHEADER, $httpheader):null;
            if(ENVIRONMENT=='development')
                curl_setopt($handle, CURLOPT_PROXY, "http://proxy.vinam.in:8080");
            $result = curl_exec($handle); 
           /* $result = '{"id":"VStwEHcvc4uMWVpx","to":["917012463778"],"from":"9544942999","canceled":false,"body":"Hi there! How are you?","type":"mt_text","created_at":"2018-05-10T04:56:00.079Z","modified_at":"2018-05-10T04:56:00.079Z","delivery_report":"none","expire_at":"2018-05-13T04:56:00.079Z","flash_message":"false"}';*/
            return $result;            
    	}	

        public function  convertToXml($data = array(),$to)
        {   
           if(!isset($data['code'])) {
                $responseArr = array (
              'code' => '200',
              'description' => 'Success',
              'recipients' =>  array (
                'recipients' =>  array (
                    'mobileNumber' => $data['to'][0] ,
                    'MessageId' => $data['id'] 
                ), 
              ),
            ); 
           } else {
                $responseArr = array (
                  'code' => '400',
                  'description' => $data['code'],
                  'recipients' =>  array (
                    'recipients' =>  array (
                        'mobileNumber' => $to ,
                       
                    ), 
                  ),
                  
                ); 
           }
            

            $xml = new SimpleXMLElement("<?xml version=\"1.0\"  encoding=\"UTF-8\"?><httpApiResponse></httpApiResponse>");
            $this->array_to_xml($responseArr,$xml);
            return $xml->asXML();
         
           
        }

        function array_to_xml($array, &$xml_user_info) {
            foreach($array as $key => $value) {
                if(is_array($value)) {
                    if(!is_numeric($key)){
                        $subnode = $xml_user_info->addChild("$key");
                        $this->array_to_xml($value, $subnode);
                    }else{
                        $subnode = $xml_user_info->addChild("item$key");
                        $this->array_to_xml($value, $subnode);
                    }
                }else {
                    $xml_user_info->addChild("$key",htmlspecialchars("$value"));
                }
            }
        }
	}
?>