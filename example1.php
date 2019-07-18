<?php
//generate JWT example
require_once('JWT.php');

//example data
$header=array(
	'alg'=>'HS256',
	'typ'=>'JWT'
);
	
$payload=array(
	'userId'=>'1',
	'userName'=>'testUser'
);

$secret="your-256-bit-secret";

//creating a class instance
$ob = new Konkretny\Features\JWT();

//print your token
echo $ob->genToken($header,$payload,$secret);

?>