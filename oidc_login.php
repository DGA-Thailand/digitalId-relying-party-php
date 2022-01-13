<?php
require 'vendor/autoload.php';
require_once "Utility.php"; // EGA Utility
require_once "Config.php"; // config

session_start();

$issuer = $issuerURL;
$cid = $clientID;
$secret = Utility::prepareSecret($clientSecret);
$oidc = new Jumbojett\OpenIDConnectClient($issuer, $cid, $secret);

$oidc->setVerifyHost(false);
$oidc->setVerifyPeer(false);

$oidc->setResponseTypes(array('code'));
$oidc->addScope(array('openid',
	'personal_token',
	'given_name',
	'citizen_id',
	'citizen_id_verified',
	'email',
	'email_verified',
	'phone_number',
	'phone_number_verified',
	'preferred_username','ial_level')
);
$oidc->setRedirectURL($loginCallbackURL);

// uncomment กรณีเปิดใช้งานแบบ PKCE เท่านั้น 
//$oidc->setCodeChallengeMethod('S256');

$oidc->authenticate();
$oidc->requestUserInfo();
$userInfo = $oidc->requestUserInfo();
//$accessToken = $oidc->getAccessToken();
$idToken = $oidc->getIdToken();
//print_r($oidc);
//print_r($accessToken);

$session = array();
foreach($userInfo as $key=> $value) {
    if(is_array($value)){
            $v = implode(', ', $value);
    }else{
            $v = $value;
    }
    $session[$key] = $v;
}
 
 
//$_SESSION['oidc'] = $oidc;
$_SESSION['attributes'] = $session;
$_SESSION['idToken'] = $idToken; 

header("Location: ./attributes.php");
 
?>
