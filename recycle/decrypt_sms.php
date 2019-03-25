<?php
header("Content-type: text/html; charset=utf-8");

class mycrypt {

public $pubkey;  
public $privkey;

function __construct() {  
                $this->pubkey = file_get_contents('./cert/rsa_public_key.pem');  
                $this->privkey = file_get_contents('./cert/private_key.pem');  
    }  

public function encrypt($data)
{
if (openssl_private_encrypt($data,$encrypted,$pi_key))
    $encrypted = base64_encode($encrypted);
else 
    throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');
return $data;
}

public function decrypt($data) {  
        if (openssl_private_decrypt(base64_decode($data), $decrypted, $this->privkey))  
            $data = $decrypted;  
        else  
            $data = '';  

        return $data;  
    }  

public function decryption($con)
{

/*
//私钥解密
openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);
echo $decrypted;
*/
	return $encrypted;
}

function encrypt_data($data)
{
    $crypt_res = "";
    for($i=0;$i<((strlen($data) - strlen($data)%117)/117+1); $i++)
    {
        $txt = mb_strcut($data, $i*117, 117, 'utf-8');
	//$crypt_res = $crypt_res.($rsa -> encrypt(mb_strcut($data, $i*117, 117, 'utf-8')));
	$crypt_res = $crypt_res.(encrypt($txt));
    }
    return $crypt_res;
}

}

$s = '[ { "teleno": "13800000000", "content": "短信内容", "data_time":"YYYY:mm:dd hh:m:ss", "imei":"99000511416902" }, { "teleno": "13800000000", "content" : "短信内容", "data_time":"YYYY:mm:dd hh:m:ss", "imei":"99000511416902" } ]';

$rsa = new mycrypt(); 
$rsa -> encrypt_data($s);

?>
