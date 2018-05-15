<?php 
include 'controller/sms.php';
$params 	= $_GET;
$smsObj 	=	 new sms();
$result = $smsObj->messageSend($params); 
print_r($result );
return $result ;

?>