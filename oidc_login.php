<?php
require 'vendor/autoload.php';
require_once "Utility.php"; // EGA Utility

session_start();

$issuer = 'https://connect.dga.or.th';
$cid = '89ee233d-0dbc-4f28-91f3-17772220cd76';
$secret = Utility::prepareSecret('G7kI60eI2Vr'); //'147b050283319c41ea68d6c6dbd7b003';
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
$oidc->setRedirectURL('http://localhost:8090/oidc_client/oidc_login.php');
 
$oidc->setCodeChallengeMethod('S256');

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