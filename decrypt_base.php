<?php
//header("Content-type: text/html; charset=utf-8");
function decrypt($data)
{
$prikey = './cert/rsa_private_key.pem';
                $fp=fopen($prikey,"r"); 
                $pri_key=fread($fp,8192); 
//私钥解密
$res = openssl_get_privatekey($pri_key);
openssl_private_decrypt(base64_decode($data),$decrypted,$res);

/*for($i = 0; $i < strlen($content)/117; $i++  ) {
        $data = substr($content, $i * 117, 117);
	openssl_private_decrypt(base64_decode($data),$decrypted,$res);
	$decrypted .= $decrypted;
}
                fclose($fp); 
*/
        return $decrypted;
}

function encrypt($data)
{
$publickey = './cert/rsa_public_key.pem';
               $fp=fopen($publickey,"r"); 
              $pub_key=fread($fp,8192); 
openssl_get_publickey($publickey);
if (openssl_public_encrypt($data,$encrypted,$pub_key))
   $encrypted = base64_encode($encrypted);
else 
    throw new Exception('Unable to encrypt data. Perhaps it is bigger than the key size?');
                fclose($fp); 
return $encrypted;
}


?>
