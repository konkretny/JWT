<?php
/*
version 1.0.0
author: Marcin Romanowicz
website: konkretny.pl
license: MIT
*/

namespace Konkretny\Features;

interface iJWT{
    public function genToken($header,$payload,$secret);
    public function loadToken($token,$secret);
}

class JWT implements iJWT{

    /**
     * Header array
     */
    private $header;

    /**
     * Payload array
     */
    private $payload;

    /**
     * secret key
     */
    private $secret;

    /**
     * JWT signature
     */
    private $signature;

    public function __construct()
    {
        if(PHP_VERSION_ID<50000){
            echo 'Your PHP version is to old. Min 5.0.0';exit;
        }

    }

    /**
     * Generate JWT Token
     */
    public function genToken($header=array(),$payload=array(),$secret=NULL){

        $this->header=$this->spec_base64_encode(json_encode($header));
        $this->payload=$this->spec_base64_encode(json_encode($payload));
        $this->secret=$secret;
        return $this->header.'.'.$this->payload.'.'.$this->createSignature();
    }

    /**
     * Load Token and return array
     */
    public function loadToken($token=NULL,$secret=NULL){
        $array = explode('.',$token);
        if(is_array($array) && count($array)===3){

            $this->header=$array[0];
            $this->payload=$array[1];
            $this->secret=$secret;

            $header_decode=json_decode($this->spec_base64_decode($array[0]));
            $payloadr_decode=json_decode($this->spec_base64_decode($array[1]));

            if($this->checkSingnature($token)){
                $signature_verified=true;
            }else{
                $signature_verified=false;
            }
            return [
                'header'=>$header_decode,
                'pyload'=>$payloadr_decode,
                'signature_verified'=>$signature_verified
            ];
           
        }else{
            return 'Token is incorrect';
        }
        
    }

    /**
     * Checks the signature
     */
    private function checkSingnature($token){
        $array = explode('.',$token);
        if(is_array($array) && $array[2]===$this->createSignature()){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Creates a signature
     */
    private function createSignature(){
        return $this->signature=$this->spec_base64_encode(hash_hmac('sha256',$this->header.'.'.$this->payload, $this->secret, true));
    }

    /**
     * Base64 friendly encode
     */
    private function spec_base64_encode($string){
        return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($string));
    }

    /**
     * Base64 friendly decode
     */    
    private function spec_base64_decode($string){
        return base64_decode(str_replace(array('-', '_', ''), array('+', '/', '='), $string));
    }

}

?>