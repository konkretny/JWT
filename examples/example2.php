<?php
//load JWT Token example
require_once('../src/JWT.php');

//example token string
$example_token_string='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VySWQiOiIxIiwidXNlck5hbWUiOiJ0ZXN0VXNlciJ9.MshVLMo8JQjuRC4Q9UOLDZfwmZEt4s4onWQcJOOIrro';
//secret
$secret="your-256-bit-secret";

//creating a class instance
$ob = new Konkretny\JWT();

//check result
echo "<pre>";
var_dump($ob->loadToken($example_token_string,$secret));
echo "</pre>";
?>